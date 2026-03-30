#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PORT="${PORT:-8110}"
BASE_URL="http://127.0.0.1:${PORT}"
DB_PATH="${ROOT_DIR}/storage/database/internhub.sqlite"
TMP_DIR="$(mktemp -d)"
SERVER_LOG="$(mktemp)"
SERVER_PID=""

cleanup() {
  if [[ -n "${SERVER_PID}" ]] && kill -0 "${SERVER_PID}" 2>/dev/null; then
    kill "${SERVER_PID}" 2>/dev/null || true
    wait "${SERVER_PID}" 2>/dev/null || true
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

extract_token() {
  sed -n 's/.*name="_token" value="\([^"]*\)".*/\1/p' "$1" | head -n1
}

http_code() {
  curl -s -o /dev/null -w '%{http_code}' "$@"
}

query_sql() {
  sqlite3 "${DB_PATH}" "$1"
}

login_as() {
  local email="$1"
  local password="$2"
  local cookie_file="$3"
  local prefix="$4"

  curl -s -c "${cookie_file}" "${BASE_URL}/login" > "${TMP_DIR}/${prefix}-login.html"
  local token
  token="$(extract_token "${TMP_DIR}/${prefix}-login.html")"

  curl -s -L -o /dev/null \
    -b "${cookie_file}" -c "${cookie_file}" \
    -X POST "${BASE_URL}/login" \
    --data-urlencode "_token=${token}" \
    --data-urlencode "email=${email}" \
    --data-urlencode "password=${password}"
}

echo "==> Reset demo data"
(cd "${ROOT_DIR}" && bash scripts/reset-demo-state.sh >/dev/null)

echo "==> Run full technical gate"
(cd "${ROOT_DIR}" && P6_PORT=8191 P7_BASE_PORT=8201 PORT=8196 bash tests/smoke/p8_http_smoke.sh >/dev/null)

echo "==> Restore frozen demo data after smoke mutations"
(cd "${ROOT_DIR}" && bash scripts/reset-demo-state.sh >/dev/null)

student_id="$(query_sql "SELECT id FROM users WHERE email = 'student@internhub.test' LIMIT 1;")"
application_id="$(query_sql "SELECT id FROM applications WHERE student_id = ${student_id} ORDER BY id ASC LIMIT 1;")"

if [[ -z "${student_id}" || -z "${application_id}" ]]; then
  fail "seeded rehearsal identifiers are missing"
fi

echo "==> Start local rehearsal server on ${BASE_URL}"
(cd "${ROOT_DIR}" && php -S "127.0.0.1:${PORT}" -t public >"${SERVER_LOG}" 2>&1) &
SERVER_PID=$!
sleep 1

if ! kill -0 "${SERVER_PID}" 2>/dev/null; then
  cat "${SERVER_LOG}" >&2 || true
  fail "server failed to start"
fi

echo "==> Check public demo path"
assert_eq "200" "$(http_code "${BASE_URL}/")" "home"
assert_eq "200" "$(http_code "${BASE_URL}/offres")" "offers"
assert_eq "200" "$(http_code "${BASE_URL}/offres/1")" "offer detail"
assert_eq "200" "$(http_code "${BASE_URL}/entreprises/1")" "company detail"
assert_eq "200" "$(http_code "${BASE_URL}/statistiques")" "statistics"

student_cookie="${TMP_DIR}/student.cookie"
pilot_cookie="${TMP_DIR}/pilot.cookie"
admin_cookie="${TMP_DIR}/admin.cookie"

echo "==> Check student demo path"
login_as "student@internhub.test" "Student123!" "${student_cookie}" "student"
assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant")" "student dashboard"
assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/candidatures")" "student applications"
assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/candidatures/${application_id}")" "student application detail"
assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/wishlist")" "student wishlist"
assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/profil")" "student profile"

echo "==> Check pilot demo path"
login_as "pilot@internhub.test" "Pilot123!" "${pilot_cookie}" "pilot"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote")" "pilot dashboard"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/etudiants")" "pilot students"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/etudiants/${student_id}")" "pilot student detail"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/etudiants/${student_id}/candidatures")" "pilot student applications"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/entreprises")" "pilot companies"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/offres")" "pilot offers"

echo "==> Check admin demo path"
login_as "admin@internhub.test" "Admin123!" "${admin_cookie}" "admin"
assert_eq "200" "$(http_code -b "${admin_cookie}" "${BASE_URL}/dashboard/admin")" "admin dashboard"
assert_eq "200" "$(http_code -b "${admin_cookie}" "${BASE_URL}/admin/comptes")" "admin accounts"
assert_eq "200" "$(http_code -b "${admin_cookie}" "${BASE_URL}/admin/entreprises")" "admin companies"
assert_eq "200" "$(http_code -b "${admin_cookie}" "${BASE_URL}/admin/offres")" "admin offers"

echo "Soutenance rehearsal passed."
