#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
PORT="${PORT:-8094}"
BASE_URL="http://127.0.0.1:${PORT}"
DB_PATH="${ROOT_DIR}/storage/database/internhub.sqlite"
SERVER_LOG="$(mktemp)"
TMP_DIR="$(mktemp -d)"
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

published_offers="$(query_sql "SELECT COUNT(*) FROM offers WHERE is_published = 1;")"
companies="$(query_sql "SELECT COUNT(*) FROM companies;")"
applications="$(query_sql "SELECT COUNT(*) FROM applications;")"

echo "Checking public statistics page..."
assert_eq "200" "$(http_code "${BASE_URL}/statistiques")" "public statistics"
public_html="$(curl -s "${BASE_URL}/statistiques")"
assert_contains "${public_html}" "Vue d ensemble des offres" "statistics title"
assert_contains "${public_html}" "Offres publiees" "published offers label"
assert_contains "${public_html}" ">${published_offers}<" "published offers value"
assert_contains "${public_html}" ">${companies}<" "company count value"
assert_contains "${public_html}" ">${applications}<" "application count value"
assert_contains "${public_html}" "Offres par ville" "locations section"
assert_contains "${public_html}" "Repartition des candidatures" "status section"

student_cookie="${TMP_DIR}/student.cookie"
pilot_cookie="${TMP_DIR}/pilot.cookie"
admin_cookie="${TMP_DIR}/admin.cookie"

echo "Checking authenticated access to statistics..."
login_as "student@internhub.test" "Student123!" "${student_cookie}" "student"
login_as "pilot@internhub.test" "Pilot123!" "${pilot_cookie}" "pilot"
login_as "admin@internhub.test" "Admin123!" "${admin_cookie}" "admin"

assert_eq "200" "$(http_code -b "${student_cookie}" "${BASE_URL}/statistiques")" "student statistics"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/statistiques")" "pilot statistics"
assert_eq "200" "$(http_code -b "${admin_cookie}" "${BASE_URL}/statistiques")" "admin statistics"

echo "P7 statistics smoke test passed."
