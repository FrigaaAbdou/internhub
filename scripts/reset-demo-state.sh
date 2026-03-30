#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
STORAGE_DIR="${ROOT_DIR}/storage"
DB_PATH="${STORAGE_DIR}/database/internhub.sqlite"

echo "Resetting demo runtime state..."

rm -f "${DB_PATH}"
find "${STORAGE_DIR}/sessions" -type f ! -name '.gitignore' -delete
find "${STORAGE_DIR}/logs" -type f ! -name '.gitignore' -delete
find "${STORAGE_DIR}/uploads" -type f ! -name '.gitignore' -delete

echo "Rebuilding SQLite demo fixture..."
(cd "${ROOT_DIR}" && php database/init-sqlite.php)

echo "Demo state ready."
