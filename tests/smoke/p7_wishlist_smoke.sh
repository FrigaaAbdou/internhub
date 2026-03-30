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

  sqlite3 "${DB_PATH}" "DELETE FROM wishlists WHERE student_id = 3;" >/dev/null 2>&1 || true
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

login_as_student() {
  local cookie_file="$1"

  curl -s -c "${cookie_file}" "${BASE_URL}/login" > "${TMP_DIR}/student-login.html"
  local token
  token="$(extract_token "${TMP_DIR}/student-login.html")"

  curl -s -o /dev/null \
    -b "${cookie_file}" -c "${cookie_file}" \
    -X POST "${BASE_URL}/login" \
    --data-urlencode "_token=${token}" \
    --data-urlencode "email=student@internhub.test" \
    --data-urlencode "password=Student123!"
}

echo "Initializing local SQLite fixture..."
(cd "${ROOT_DIR}" && php database/init-sqlite.php >/dev/null)
sqlite3 "${DB_PATH}" "DELETE FROM wishlists WHERE student_id = 3;" >/dev/null

echo "Starting local PHP server on ${BASE_URL}..."
(cd "${ROOT_DIR}" && php -S "127.0.0.1:${PORT}" -t public >"${SERVER_LOG}" 2>&1) &
SERVER_PID=$!
sleep 1

if ! kill -0 "${SERVER_PID}" 2>/dev/null; then
  cat "${SERVER_LOG}" >&2 || true
  fail "server failed to start"
fi

student_cookie="${TMP_DIR}/student.cookie"
login_as_student "${student_cookie}"

assert_eq "200" "$(curl -s -o /dev/null -w '%{http_code}' -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/wishlist")" "wishlist page"

offer_page="$(curl -s -b "${student_cookie}" "${BASE_URL}/offres/1")"
assert_contains "${offer_page}" "Ajouter a ma wish-list" "offer wishlist add CTA"

offer_page_token="$(extract_token <(printf '%s' "${offer_page}"))"
curl -s -o /dev/null \
  -b "${student_cookie}" -c "${student_cookie}" \
  -X POST "${BASE_URL}/offres/1/wishlist" \
  --data-urlencode "_token=${offer_page_token}"

assert_eq "1" "$(sqlite3 "${DB_PATH}" "SELECT COUNT(*) FROM wishlists WHERE student_id = 3 AND offer_id = 1;")" "wishlist insert"

curl -s -o /dev/null \
  -b "${student_cookie}" -c "${student_cookie}" \
  -X POST "${BASE_URL}/offres/1/wishlist" \
  --data-urlencode "_token=${offer_page_token}"

assert_eq "1" "$(sqlite3 "${DB_PATH}" "SELECT COUNT(*) FROM wishlists WHERE student_id = 3 AND offer_id = 1;")" "wishlist duplicate blocked"

wishlist_page="$(curl -s -b "${student_cookie}" "${BASE_URL}/dashboard/etudiant/wishlist")"
assert_contains "${wishlist_page}" "Stage Data Analyst" "wishlist content"

wishlist_token="$(extract_token <(printf '%s' "${wishlist_page}"))"
curl -s -o /dev/null \
  -b "${student_cookie}" -c "${student_cookie}" \
  -X POST "${BASE_URL}/dashboard/etudiant/wishlist/1/delete" \
  --data-urlencode "_token=${wishlist_token}"

assert_eq "0" "$(sqlite3 "${DB_PATH}" "SELECT COUNT(*) FROM wishlists WHERE student_id = 3 AND offer_id = 1;")" "wishlist delete"

echo "P7 wishlist smoke test passed."
