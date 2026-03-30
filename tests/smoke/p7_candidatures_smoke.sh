#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
PORT="${PORT:-8091}"
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

  sqlite3 "${DB_PATH}" "
    DELETE FROM applications WHERE id IN (9001, 9002);
    DELETE FROM users WHERE id IN (901, 902);
  " >/dev/null 2>&1 || true

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

  curl -s -o /dev/null \
    -b "${cookie_file}" -c "${cookie_file}" \
    -X POST "${BASE_URL}/login" \
    --data-urlencode "_token=${token}" \
    --data-urlencode "email=${email}" \
    --data-urlencode "password=${password}"
}

echo "Initializing local SQLite fixture..."
(cd "${ROOT_DIR}" && php database/init-sqlite.php >/dev/null)

sqlite3 "${DB_PATH}" "
  DELETE FROM applications WHERE id IN (9001, 9002);
  DELETE FROM users WHERE id IN (901, 902);
  INSERT INTO users (id, first_name, last_name, email, password_hash, role, promotion_id, created_at)
  VALUES
    (901, 'Other', 'Promo', 'other-promo@internhub.test', 'x', 'etudiant', 1, datetime('now')),
    (902, 'Outside', 'Promo', 'outside-promo@internhub.test', 'x', 'etudiant', 999, datetime('now'));
  INSERT INTO applications (id, student_id, offer_id, status, created_at, cover_letter, cv_path)
  VALUES
    (9001, 901, 3, 'envoyee', datetime('now'), 'Lettre de motivation de test hors perimetre.', 'uploads/cv/cv-student-3-offer-3-f384e9c63a52.pdf'),
    (9002, 902, 3, 'envoyee', datetime('now'), 'Lettre de motivation hors promo.', 'uploads/cv/cv-student-3-offer-3-f384e9c63a52.pdf');
" >/dev/null

echo "Starting local PHP server on ${BASE_URL}..."
(cd "${ROOT_DIR}" && php -S "127.0.0.1:${PORT}" -t public >"${SERVER_LOG}" 2>&1) &
SERVER_PID=$!
sleep 1

if ! kill -0 "${SERVER_PID}" 2>/dev/null; then
  cat "${SERVER_LOG}" >&2 || true
  fail "server failed to start"
fi

student_cookie="${TMP_DIR}/student.cookie"
pilot_cookie="${TMP_DIR}/pilot.cookie"

login_as "student@internhub.test" "Student123!" "${student_cookie}" "student"
login_as "pilot@internhub.test" "Pilot123!" "${pilot_cookie}" "pilot"

student_id="$(query_sql "SELECT id FROM users WHERE email = 'student@internhub.test' LIMIT 1;")"
application_id="$(query_sql "SELECT id FROM applications WHERE student_id = ${student_id} ORDER BY id ASC LIMIT 1;")"

[[ -n "${student_id}" ]] || fail "student fixture id not found"
[[ -n "${application_id}" ]] || fail "seeded application id not found"

echo "Checking student candidature detail and CV download..."
student_detail="$(curl -s -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/candidatures/${application_id}")"
assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/candidatures/${application_id}")" "student detail"
assert_contains "${student_detail}" "Lettre de motivation" "student detail"

curl -s -D "${TMP_DIR}/student-cv.headers" -o "${TMP_DIR}/student-cv.bin" \
  -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/candidatures/${application_id}/cv" >/dev/null

assert_eq "200" "$(awk 'NR==1 {print $2}' "${TMP_DIR}/student-cv.headers")" "student cv status"
assert_eq "application/pdf" "$(awk 'BEGIN{IGNORECASE=1} /^Content-Type:/ {print $2}' "${TMP_DIR}/student-cv.headers" | tr -d '\r' | tail -n1)" "student cv type"
assert_eq "403" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/candidatures/9001")" "student forbidden foreign application"
assert_eq "404" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/candidatures/99999")" "student missing application"

echo "Checking pilot candidature detail and CV download..."
pilot_detail="$(curl -s -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/candidatures/${application_id}")"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/candidatures/${application_id}")" "pilot detail"
assert_contains "${pilot_detail}" "Etudiant" "pilot detail"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/candidatures/9001")" "pilot same-promo application"
assert_eq "403" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/candidatures/9002")" "pilot forbidden outside-promo"

curl -s -D "${TMP_DIR}/pilot-cv.headers" -o "${TMP_DIR}/pilot-cv.bin" \
  -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/candidatures/${application_id}/cv" >/dev/null

assert_eq "200" "$(awk 'NR==1 {print $2}' "${TMP_DIR}/pilot-cv.headers")" "pilot cv status"
assert_eq "application/pdf" "$(awk 'BEGIN{IGNORECASE=1} /^Content-Type:/ {print $2}' "${TMP_DIR}/pilot-cv.headers" | tr -d '\r' | tail -n1)" "pilot cv type"

echo "P7 candidature smoke test passed."
