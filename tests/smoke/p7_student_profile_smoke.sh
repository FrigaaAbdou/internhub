#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
PORT="${PORT:-8095}"
BASE_URL="http://127.0.0.1:${PORT}"
DB_PATH="${ROOT_DIR}/storage/database/internhub.sqlite"
SERVER_LOG="$(mktemp)"
TMP_DIR="$(mktemp -d)"
SERVER_PID=""
ORIGINAL_EMAIL="student@internhub.test"
ORIGINAL_FIRST_NAME=""
ORIGINAL_LAST_NAME=""
UPDATED_EMAIL="student.profile.updated@internhub.test"
UPDATED_PASSWORD="Student456!"
UPDATED_FIRST_NAME="EmmaProfile"
UPDATED_LAST_NAME="StudentProfile"

cleanup() {
  if [[ -n "${SERVER_PID}" ]] && kill -0 "${SERVER_PID}" 2>/dev/null; then
    kill "${SERVER_PID}" 2>/dev/null || true
    wait "${SERVER_PID}" 2>/dev/null || true
  fi

  if [[ -f "${DB_PATH}" && -n "${ORIGINAL_FIRST_NAME}" && -n "${ORIGINAL_LAST_NAME}" ]]; then
    sqlite3 "${DB_PATH}" "
      UPDATE users
      SET first_name = '${ORIGINAL_FIRST_NAME}',
          last_name = '${ORIGINAL_LAST_NAME}',
          email = '${ORIGINAL_EMAIL}',
          password_hash = '$(php -r "echo password_hash('Student123!', PASSWORD_DEFAULT);")'
      WHERE email IN ('${ORIGINAL_EMAIL}', '${UPDATED_EMAIL}');
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

header_location() {
  local headers_file="$1"

  awk 'BEGIN{IGNORECASE=1} /^Location:/ {print $2}' "${headers_file}" | tr -d '\r' | tail -n1
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

query_sql() {
  sqlite3 "${DB_PATH}" "$1"
}

echo "Initializing local SQLite fixture..."
(cd "${ROOT_DIR}" && php database/init-sqlite.php >/dev/null)

ORIGINAL_FIRST_NAME="$(query_sql "SELECT first_name FROM users WHERE email = '${ORIGINAL_EMAIL}' LIMIT 1;")"
ORIGINAL_LAST_NAME="$(query_sql "SELECT last_name FROM users WHERE email = '${ORIGINAL_EMAIL}' LIMIT 1;")"

[[ -n "${ORIGINAL_FIRST_NAME}" ]] || fail "student fixture not found"

echo "Starting local PHP server on ${BASE_URL}..."
(cd "${ROOT_DIR}" && php -S "127.0.0.1:${PORT}" -t public >"${SERVER_LOG}" 2>&1) &
SERVER_PID=$!
sleep 1

if ! kill -0 "${SERVER_PID}" 2>/dev/null; then
  cat "${SERVER_LOG}" >&2 || true
  fail "server failed to start"
fi

student_cookie="${TMP_DIR}/student.cookie"

echo "Checking student profile page..."
login_as "${ORIGINAL_EMAIL}" "Student123!" "${student_cookie}" "student"
assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/profil")" "student profile page"

curl -s -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/profil" > "${TMP_DIR}/student-profile.html"
assert_contains "$(cat "${TMP_DIR}/student-profile.html")" "Mon profil" "profile title"
assert_contains "$(cat "${TMP_DIR}/student-profile.html")" "${ORIGINAL_EMAIL}" "profile current email"

profile_token="$(extract_token "${TMP_DIR}/student-profile.html")"

curl -s -D "${TMP_DIR}/student-profile-update.headers" -o /dev/null \
  -b "${student_cookie}" -c "${student_cookie}" \
  -X POST "${BASE_URL}/dashboard/etudiant/profil" \
  --data-urlencode "_token=${profile_token}" \
  --data-urlencode "first_name=${UPDATED_FIRST_NAME}" \
  --data-urlencode "last_name=${UPDATED_LAST_NAME}" \
  --data-urlencode "email=${UPDATED_EMAIL}" \
  --data-urlencode "password=${UPDATED_PASSWORD}"

assert_eq "/dashboard/etudiant/profil" "$(header_location "${TMP_DIR}/student-profile-update.headers")" "profile update redirect"
assert_eq "1" "$(query_sql "SELECT COUNT(*) FROM users WHERE email = '${UPDATED_EMAIL}' AND first_name = '${UPDATED_FIRST_NAME}' AND last_name = '${UPDATED_LAST_NAME}';")" "profile update persisted"

echo "Checking login with updated password..."
updated_cookie="${TMP_DIR}/student-updated.cookie"
login_as "${UPDATED_EMAIL}" "${UPDATED_PASSWORD}" "${updated_cookie}" "student-updated"
assert_eq "/dashboard/etudiant" "$(header_location "${TMP_DIR}/student-updated-login.headers")" "updated profile login redirect"
assert_eq "200" "$(http_code -b "${updated_cookie}" "${BASE_URL}/dashboard/etudiant/profil")" "updated profile page"

echo "P7 student profile smoke test passed."
