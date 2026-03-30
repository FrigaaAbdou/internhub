#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
BASE_PORT="${BASE_PORT:-8091}"

run_step() {
  local label="$1"
  local script_path="$2"
  local port="$3"

  echo "==> ${label}"
  PORT="${port}" bash "${ROOT_DIR}/${script_path}"
}

run_step "P7.1 candidatures" "tests/smoke/p7_candidatures_smoke.sh" "${BASE_PORT}"
run_step "P7.2 wish-list" "tests/smoke/p7_wishlist_smoke.sh" "$((BASE_PORT + 1))"
run_step "P7.3 suivi pilote" "tests/smoke/p7_pilot_followup_smoke.sh" "$((BASE_PORT + 2))"
run_step "P7.4 statistiques" "tests/smoke/p7_statistics_smoke.sh" "$((BASE_PORT + 3))"
run_step "P7.5 profil etudiant" "tests/smoke/p7_student_profile_smoke.sh" "$((BASE_PORT + 4))"

echo "P7 smoke test passed."
