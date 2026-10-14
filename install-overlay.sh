#!/usr/bin/env bash
# Menyalin file inventory ke project Laravel baru.
# Pemakaian:  bash install-overlay.sh /path/ke/project-laravel
set -e
TARGET="${1:?Isi path project Laravel tujuan}"
HERE="$(cd "$(dirname "$0")" && pwd)"
for d in app database resources routes docs; do cp -r "$HERE/$d" "$TARGET/"; done
cp "$HERE/README.md" "$TARGET/README.md"
echo "Selesai. Lanjut: cd $TARGET && php artisan migrate --seed"
