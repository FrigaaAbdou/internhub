#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
PORT="${PORT:-8091}"
BASE_URL="http://127.0.0.1:${PORT}"
DB_PATH="${ROOT_DIR}/storage/database/internhub.sqlite"
SERVER_LOG="$(mktemp)"
TMP_DIR="$(mktemp -d)"
SERVER_PID=""
STAMP="smoke-p6-$(date +%s)"

cleanup() {
  if [[ -n "${SERVER_PID}" ]] && kill -0 "${SERVER_PID}" 2>/dev/null; then
    kill "${SERVER_PID}" 2>/dev/null || true
    wait "${SERVER_PID}" 2>/dev/null || true
  fi

  if [[ -f "${DB_PATH}" ]]; then
    sqlite3 "${DB_PATH}" "
      DELETE FROM applications
      WHERE student_id IN (SELECT id FROM users WHERE email LIKE '${STAMP}%')
         OR offer_id IN (SELECT id FROM offers WHERE title LIKE '${STAMP}%');
      DELETE FROM users WHERE email LIKE '${STAMP}%';
      DELETE FROM offers WHERE title LIKE '${STAMP}%';
      DELETE FROM companies WHERE name LIKE '${STAMP}%';
    " >/dev/null 2>&1 || true
  fi

  rm -rf "${TMP_DIR}"
  rm -f "${SERVER_LOG}"
}

trap cleanup EXIT

fail() {
  echo "FAIL: $*" >&2
  exit 1
}

assert_eq() {
  local expected="$1"
  local actual="$2"
  local label="$3"

  if [[ "${expected}" != "${actual}" ]]; then
    fail "${label} expected '${expected}' but got '${actual}'"
  fi
}

assert_contains() {
  local haystack="$1"
  local needle="$2"
  local label="$3"

  if ! grep -Fq "${needle}" <<<"${haystack}"; then
    fail "${label} missing '${needle}'"
  fi
}

extract_token() {
  sed -n 's/.*name="_token" value="\([^"]*\)".*/\1/p' "$1" | head -n1
}

http_code() {
  curl -s -o /dev/null -w '%{http_code}' "$@"
}

login_as() {
  local email="$1"
  local password="$2"
  local cookie_file="$3"
  local prefix="$4"

  curl -s -c "${cookie_file}" "${BASE_URL}/login" > "${TMP_DIR}/${prefix}-login.html"
  local token
  token="$(extract_token "${TMP_DIR}/${prefix}-login.html")"

  curl -s -D "${TMP_DIR}/${prefix}-login.headers" -o /dev/null \
    -b "${cookie_file}" -c "${cookie_file}" \
    -X POST "${BASE_URL}/login" \
    --data-urlencode "_token=${token}" \
    --data-urlencode "email=${email}" \
    --data-urlencode "password=${password}"
}

header_location() {
  local headers_file="$1"

  awk 'BEGIN{IGNORECASE=1} /^Location:/ {print $2}' "${headers_file}" | tr -d '\r' | tail -n1
}

query_sql() {
  sqlite3 "${DB_PATH}" "$1"
}

echo "Initializing local SQLite fixture..."
(cd "${ROOT_DIR}" && php database/init-sqlite.php >/dev/null)

echo "Starting local PHP server on ${BASE_URL}..."
(cd "${ROOT_DIR}" && php -S "127.0.0.1:${PORT}" -t public >"${SERVER_LOG}" 2>&1) &
SERVER_PID=$!
sleep 1

if ! kill -0 "${SERVER_PID}" 2>/dev/null; then
  cat "${SERVER_LOG}" >&2 || true
  fail "server failed to start"
fi

echo "Checking public modules..."
assert_eq "200" "$(http_code "${BASE_URL}/offres")" "public offers"
assert_eq "200" "$(http_code "${BASE_URL}/entreprises")" "public companies"
assert_eq "200" "$(http_code "${BASE_URL}/offres?location=Paris")" "offers filter"
assert_eq "200" "$(http_code "${BASE_URL}/entreprises?q=Blue")" "company search"

public_offer_html="$(curl -s "${BASE_URL}/offres?page=1")"
assert_contains "${public_offer_html}" "Consulter les opportunites" "offers list"

public_company_html="$(curl -s "${BASE_URL}/entreprises/1")"
assert_contains "${public_company_html}" "Offres publiees" "company detail"

student_cookie="${TMP_DIR}/student.cookie"
pilot_cookie="${TMP_DIR}/pilot.cookie"
admin_cookie="${TMP_DIR}/admin.cookie"

echo "Checking role redirects and dashboards..."
login_as "student@internhub.test" "Student123!" "${student_cookie}" "student"
assert_eq "/dashboard/etudiant" "$(header_location "${TMP_DIR}/student-login.headers")" "student redirect"
assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant")" "student dashboard"

login_as "pilot@internhub.test" "Pilot123!" "${pilot_cookie}" "pilot"
assert_eq "/dashboard/pilote" "$(header_location "${TMP_DIR}/pilot-login.headers")" "pilot redirect"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote")" "pilot dashboard"

login_as "admin@internhub.test" "Admin123!" "${admin_cookie}" "admin"
assert_eq "/dashboard/admin" "$(header_location "${TMP_DIR}/admin-login.headers")" "admin redirect"
assert_eq "200" "$(http_code -b "${admin_cookie}" "${BASE_URL}/dashboard/admin")" "admin dashboard"

assert_eq "403" "$(http_code -b "${student_cookie}" "${BASE_URL}/admin/offres")" "student denied admin offers"
assert_eq "403" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/pilote/entreprises")" "student denied pilot companies"
assert_eq "403" "$(http_code -b "${admin_cookie}" "${BASE_URL}/dashboard/pilote")" "admin denied pilot dashboard"

echo "Checking account management..."
curl -s -b "${admin_cookie}" "${BASE_URL}/admin/comptes/create" > "${TMP_DIR}/admin-account-create.html"
admin_account_token="$(extract_token "${TMP_DIR}/admin-account-create.html")"
student_email="${STAMP}-student@internhub.test"

curl -s -D "${TMP_DIR}/admin-account-create.headers" -o /dev/null \
  -b "${admin_cookie}" -c "${admin_cookie}" \
  -X POST "${BASE_URL}/admin/comptes/create" \
  --data-urlencode "_token=${admin_account_token}" \
  --data-urlencode "first_name=Smoke" \
  --data-urlencode "last_name=Student" \
  --data-urlencode "email=${student_email}" \
  --data-urlencode "role=etudiant" \
  --data-urlencode "promotion_id=1" \
  --data-urlencode "password=Student987!"

assert_eq "/admin/comptes" "$(header_location "${TMP_DIR}/admin-account-create.headers")" "admin account create redirect"
student_id="$(query_sql "SELECT id FROM users WHERE email = '${student_email}' LIMIT 1;")"
[[ -n "${student_id}" ]] || fail "admin-created student not found in database"

curl -s -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/etudiants/${student_id}/edit" > "${TMP_DIR}/pilot-student-edit.html"
pilot_student_token="$(extract_token "${TMP_DIR}/pilot-student-edit.html")"
pilot_student_email="${STAMP}-student-updated@internhub.test"

curl -s -D "${TMP_DIR}/pilot-student-update.headers" -o /dev/null \
  -b "${pilot_cookie}" -c "${pilot_cookie}" \
  -X POST "${BASE_URL}/dashboard/pilote/etudiants/${student_id}/edit" \
  --data-urlencode "_token=${pilot_student_token}" \
  --data-urlencode "first_name=Smoke" \
  --data-urlencode "last_name=Updated" \
  --data-urlencode "email=${pilot_student_email}" \
  --data-urlencode "password="

assert_eq "/dashboard/pilote/etudiants" "$(header_location "${TMP_DIR}/pilot-student-update.headers")" "pilot student update redirect"
assert_eq "1" "$(query_sql "SELECT COUNT(*) FROM users WHERE id = ${student_id} AND email = '${pilot_student_email}';")" "pilot student update persisted"

curl -s -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/etudiants" > "${TMP_DIR}/pilot-students.html"
pilot_student_delete_token="$(extract_token "${TMP_DIR}/pilot-students.html")"

curl -s -D "${TMP_DIR}/pilot-student-delete.headers" -o /dev/null \
  -b "${pilot_cookie}" -c "${pilot_cookie}" \
  -X POST "${BASE_URL}/dashboard/pilote/etudiants/${student_id}/delete" \
  --data-urlencode "_token=${pilot_student_delete_token}"

assert_eq "/dashboard/pilote/etudiants" "$(header_location "${TMP_DIR}/pilot-student-delete.headers")" "pilot student delete redirect"
assert_eq "0" "$(query_sql "SELECT COUNT(*) FROM users WHERE id = ${student_id};")" "pilot student deletion persisted"

echo "Checking company management..."
curl -s -b "${admin_cookie}" "${BASE_URL}/admin/entreprises/create" > "${TMP_DIR}/admin-company-create.html"
admin_company_token="$(extract_token "${TMP_DIR}/admin-company-create.html")"
company_name="${STAMP}-company-admin"

curl -s -D "${TMP_DIR}/admin-company-create.headers" -o /dev/null \
  -b "${admin_cookie}" -c "${admin_cookie}" \
  -X POST "${BASE_URL}/admin/entreprises/create" \
  --data-urlencode "_token=${admin_company_token}" \
  --data-urlencode "name=${company_name}" \
  --data-urlencode "industry=Fintech" \
  --data-urlencode "city=Paris" \
  --data-urlencode "website=https://example.test" \
  --data-urlencode "description=Entreprise de test P6."

assert_eq "/admin/entreprises" "$(header_location "${TMP_DIR}/admin-company-create.headers")" "admin company create redirect"
company_id="$(query_sql "SELECT id FROM companies WHERE name = '${company_name}' LIMIT 1;")"
[[ -n "${company_id}" ]] || fail "admin-created company not found in database"

curl -s -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/entreprises/${company_id}/edit" > "${TMP_DIR}/pilot-company-edit.html"
pilot_company_token="$(extract_token "${TMP_DIR}/pilot-company-edit.html")"
updated_company_name="${STAMP}-company-updated"

curl -s -D "${TMP_DIR}/pilot-company-update.headers" -o /dev/null \
  -b "${pilot_cookie}" -c "${pilot_cookie}" \
  -X POST "${BASE_URL}/dashboard/pilote/entreprises/${company_id}/edit" \
  --data-urlencode "_token=${pilot_company_token}" \
  --data-urlencode "name=${updated_company_name}" \
  --data-urlencode "industry=Conseil" \
  --data-urlencode "city=Lyon" \
  --data-urlencode "website=https://example-updated.test" \
  --data-urlencode "description=Entreprise modifiee par pilote."

assert_eq "/dashboard/pilote/entreprises" "$(header_location "${TMP_DIR}/pilot-company-update.headers")" "pilot company update redirect"
assert_eq "1" "$(query_sql "SELECT COUNT(*) FROM companies WHERE id = ${company_id} AND name = '${updated_company_name}';")" "pilot company update persisted"

curl -s -b "${admin_cookie}" "${BASE_URL}/admin/entreprises" > "${TMP_DIR}/admin-companies.html"
company_delete_token="$(extract_token "${TMP_DIR}/admin-companies.html")"
curl -s -D "${TMP_DIR}/admin-company-guard.headers" -o /dev/null \
  -b "${admin_cookie}" -c "${admin_cookie}" \
  -X POST "${BASE_URL}/admin/entreprises/1/delete" \
  --data-urlencode "_token=${company_delete_token}"
assert_eq "/admin/entreprises" "$(header_location "${TMP_DIR}/admin-company-guard.headers")" "company guard redirect"
assert_eq "1" "$(query_sql "SELECT COUNT(*) FROM companies WHERE id = 1;")" "company guard preserved company"

curl -s -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/entreprises" > "${TMP_DIR}/pilot-companies.html"
pilot_company_delete_token="$(extract_token "${TMP_DIR}/pilot-companies.html")"
curl -s -D "${TMP_DIR}/pilot-company-delete.headers" -o /dev/null \
  -b "${pilot_cookie}" -c "${pilot_cookie}" \
  -X POST "${BASE_URL}/dashboard/pilote/entreprises/${company_id}/delete" \
  --data-urlencode "_token=${pilot_company_delete_token}"

assert_eq "/dashboard/pilote/entreprises" "$(header_location "${TMP_DIR}/pilot-company-delete.headers")" "pilot company delete redirect"
assert_eq "0" "$(query_sql "SELECT COUNT(*) FROM companies WHERE id = ${company_id};")" "pilot company deletion persisted"

echo "Checking offer management..."
curl -s -b "${admin_cookie}" "${BASE_URL}/admin/offres/create" > "${TMP_DIR}/admin-offer-create.html"
admin_offer_token="$(extract_token "${TMP_DIR}/admin-offer-create.html")"
offer_title="${STAMP}-offer-draft"

curl -s -D "${TMP_DIR}/admin-offer-create.headers" -o /dev/null \
  -b "${admin_cookie}" -c "${admin_cookie}" \
  -X POST "${BASE_URL}/admin/offres/create" \
  --data-urlencode "_token=${admin_offer_token}" \
  --data-urlencode "company_id=1" \
  --data-urlencode "title=${offer_title}" \
  --data-urlencode "location=Paris" \
  --data-urlencode "contract_type=Stage 6 mois" \
  --data-urlencode "description=Offre brouillon de test."

assert_eq "/admin/offres" "$(header_location "${TMP_DIR}/admin-offer-create.headers")" "admin offer create redirect"
offer_id="$(query_sql "SELECT id FROM offers WHERE title = '${offer_title}' LIMIT 1;")"
[[ -n "${offer_id}" ]] || fail "admin-created offer not found in database"
assert_eq "404" "$(http_code "${BASE_URL}/offres/${offer_id}")" "draft offer stays private"

curl -s -b "${admin_cookie}" "${BASE_URL}/admin/offres/${offer_id}/edit" > "${TMP_DIR}/admin-offer-edit.html"
admin_offer_edit_token="$(extract_token "${TMP_DIR}/admin-offer-edit.html")"
published_offer_title="${STAMP}-offer-published"

curl -s -D "${TMP_DIR}/admin-offer-update.headers" -o /dev/null \
  -b "${admin_cookie}" -c "${admin_cookie}" \
  -X POST "${BASE_URL}/admin/offres/${offer_id}/edit" \
  --data-urlencode "_token=${admin_offer_edit_token}" \
  --data-urlencode "company_id=1" \
  --data-urlencode "title=${published_offer_title}" \
  --data-urlencode "location=Lyon" \
  --data-urlencode "contract_type=Alternance" \
  --data-urlencode "description=Offre publiee de test." \
  --data-urlencode "is_published=1"

assert_eq "/admin/offres" "$(header_location "${TMP_DIR}/admin-offer-update.headers")" "admin offer update redirect"
assert_eq "200" "$(http_code "${BASE_URL}/offres/${offer_id}")" "published offer becomes public"

curl -s -b "${admin_cookie}" "${BASE_URL}/admin/offres" > "${TMP_DIR}/admin-offers.html"
offer_guard_token="$(extract_token "${TMP_DIR}/admin-offers.html")"
curl -s -D "${TMP_DIR}/admin-offer-guard.headers" -o /dev/null \
  -b "${admin_cookie}" -c "${admin_cookie}" \
  -X POST "${BASE_URL}/admin/offres/1/delete" \
  --data-urlencode "_token=${offer_guard_token}"
assert_eq "/admin/offres" "$(header_location "${TMP_DIR}/admin-offer-guard.headers")" "offer guard redirect"
assert_eq "1" "$(query_sql "SELECT COUNT(*) FROM offers WHERE id = 1;")" "offer guard preserved offer"

curl -s -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/offres" > "${TMP_DIR}/pilot-offers.html"
pilot_offer_delete_token="$(extract_token "${TMP_DIR}/pilot-offers.html")"
curl -s -D "${TMP_DIR}/pilot-offer-delete.headers" -o /dev/null \
  -b "${pilot_cookie}" -c "${pilot_cookie}" \
  -X POST "${BASE_URL}/dashboard/pilote/offres/${offer_id}/delete" \
  --data-urlencode "_token=${pilot_offer_delete_token}"

assert_eq "/dashboard/pilote/offres" "$(header_location "${TMP_DIR}/pilot-offer-delete.headers")" "pilot offer delete redirect"
assert_eq "0" "$(query_sql "SELECT COUNT(*) FROM offers WHERE id = ${offer_id};")" "pilot offer deletion persisted"

echo "P6 smoke test passed."
