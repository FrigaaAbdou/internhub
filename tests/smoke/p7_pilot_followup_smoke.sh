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
    DELETE FROM applications WHERE id = 9100;
    DELETE FROM users WHERE id = 910;
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

echo "Initializing local SQLite fixture..."
(cd "${ROOT_DIR}" && php database/init-sqlite.php >/dev/null)

sqlite3 "${DB_PATH}" "
  DELETE FROM applications WHERE id = 9100;
  DELETE FROM users WHERE id = 910;
  INSERT INTO users (id, first_name, last_name, email, password_hash, role, promotion_id, created_at)
  VALUES (910, 'Outside', 'Promo', 'pilot-followup-outside@internhub.test', 'x', 'etudiant', 999, datetime('now'));
  INSERT INTO applications (id, student_id, offer_id, status, created_at, cover_letter, cv_path)
  VALUES (9100, 910, 3, 'envoyee', datetime('now'), 'Lettre hors promo.', 'uploads/cv/cv-student-3-offer-3-f384e9c63a52.pdf');
" >/dev/null

echo "Starting local PHP server on ${BASE_URL}..."
(cd "${ROOT_DIR}" && php -S "127.0.0.1:${PORT}" -t public >"${SERVER_LOG}" 2>&1) &
SERVER_PID=$!
sleep 1

if ! kill -0 "${SERVER_PID}" 2>/dev/null; then
  cat "${SERVER_LOG}" >&2 || true
  fail "server failed to start"
fi

pilot_cookie="${TMP_DIR}/pilot.cookie"

curl -s -c "${pilot_cookie}" "${BASE_URL}/login" > "${TMP_DIR}/pilot-login.html"
token="$(extract_token "${TMP_DIR}/pilot-login.html")"
curl -s -o /dev/null -b "${pilot_cookie}" -c "${pilot_cookie}" \
  -X POST "${BASE_URL}/login" \
  --data-urlencode "_token=${token}" \
  --data-urlencode "email=pilot@internhub.test" \
  --data-urlencode "password=Pilot123!"

echo "Checking pilot dashboard and student supervision..."
dashboard="$(curl -s -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote")"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote")" "pilot dashboard"
assert_contains "${dashboard}" "Activite recente de la promotion" "pilot dashboard"

student_page="$(curl -s -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/etudiants/3")"
assert_eq "200" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/etudiants/3")" "pilot student detail"
assert_contains "${student_page}" "Dernieres candidatures" "pilot student detail"

assert_eq "403" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/etudiants/910")" "pilot denied outside-promo student"
assert_eq "403" "$(http_code -b "${pilot_cookie}" "${BASE_URL}/dashboard/pilote/candidatures/9100")" "pilot denied outside-promo candidature"

echo "P7 pilot follow-up smoke test passed."
