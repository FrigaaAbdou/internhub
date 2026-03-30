#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
PORT="${PORT:-8096}"
P6_PORT="${P6_PORT:-8091}"
P7_BASE_PORT="${P7_BASE_PORT:-8101}"
BASE_URL="http://127.0.0.1:${PORT}"
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

assert_contains() {
  local haystack="$1"
  local needle="$2"
  local label="$3"

  if ! grep -Fq "${needle}" <<<"${haystack}"; then
    fail "${label} missing '${needle}'"
  fi
}

assert_not_contains() {
  local haystack="$1"
  local needle="$2"
  local label="$3"

  if grep -Fq "${needle}" <<<"${haystack}"; then
    fail "${label} unexpectedly contains '${needle}'"
  fi
}

run_step() {
  local label="$1"
  local command="$2"

  echo "==> ${label}"
  (cd "${ROOT_DIR}" && eval "${command}")
}

echo "==> PHP lint on P8 shared files"
(cd "${ROOT_DIR}" && php -l config/app.php >/dev/null)
(cd "${ROOT_DIR}" && php -l app/Core/helpers.php >/dev/null)
(cd "${ROOT_DIR}" && php -l app/Core/Controller.php >/dev/null)
(cd "${ROOT_DIR}" && php -l app/Controllers/HomeController.php >/dev/null)
(cd "${ROOT_DIR}" && php -l app/Views/layouts/app.php >/dev/null)
(cd "${ROOT_DIR}" && php -l app/Views/partials/header.php >/dev/null)
(cd "${ROOT_DIR}" && php -l app/Views/partials/footer.php >/dev/null)
(cd "${ROOT_DIR}" && php -l app/Views/legal/mentions.php >/dev/null)

run_step "PHPUnit" "./vendor/bin/phpunit"
run_step "P6 smoke" "PORT=${P6_PORT} bash tests/smoke/p6_http_smoke.sh"
run_step "P7 smoke" "BASE_PORT=${P7_BASE_PORT} bash tests/smoke/p7_http_smoke.sh"

echo "==> P8-specific HTTP checks"
(cd "${ROOT_DIR}" && php database/init-sqlite.php >/dev/null)
(cd "${ROOT_DIR}" && php -S "127.0.0.1:${PORT}" -t public >"${SERVER_LOG}" 2>&1) &
SERVER_PID=$!
sleep 1

if ! kill -0 "${SERVER_PID}" 2>/dev/null; then
  cat "${SERVER_LOG}" >&2 || true
  fail "server failed to start"
fi

home_html="$(curl -sS "${BASE_URL}/")"
legal_html="$(curl -sS "${BASE_URL}/mentions-legales")"
offer_html="$(curl -sS "${BASE_URL}/offres/1")"
home_nav_html="$(printf '%s' "${home_html}" | sed -n '/<nav class="site-nav"/,/<\/nav>/p')"

assert_contains "${home_html}" "<title>Accueil | InternHub</title>" "home title"
assert_contains "${home_html}" "meta name=\"description\"" "home meta description"
assert_contains "${home_html}" "href=\"/mentions-legales\"" "footer legal link"
assert_not_contains "${home_nav_html}" "href=\"/health\"" "main navigation health link"

assert_contains "${legal_html}" "<title>Mentions legales | InternHub</title>" "legal title"
assert_contains "${legal_html}" "Donnees personnelles" "legal content"
assert_contains "${legal_html}" "Hebergement" "legal hosting section"

assert_contains "${offer_html}" "<title>Stage Data Analyst | InternHub</title>" "offer meta title"
assert_contains "${offer_html}" "meta name=\"description\" content=\"Analyse de donnees, reporting et visualisation.\"" "offer meta description"

echo "P8 smoke test passed."
