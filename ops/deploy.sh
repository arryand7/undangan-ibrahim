#!/usr/bin/env bash
set -euo pipefail

APP_DIR="/var/www/ibrahim.sabira-iibs.id"
WEB_USER="www-data"
PHP_FPM_SERVICE="php8.4-fpm"
BRANCH="${1:-main}"
LOCK_FILE="/tmp/ibrahim-deploy.lock"
LOG_FILE="/var/log/ibrahim-deploy.log"

if [[ "$(id -u)" -ne 0 ]]; then
  echo "This deploy script must run as root." >&2
  exit 1
fi

exec >>"$LOG_FILE" 2>&1

log() {
  printf '[%s] %s\n' "$(date '+%Y-%m-%d %H:%M:%S')" "$*"
}

run_as_web_user() {
  runuser -u "$WEB_USER" -- /bin/bash -lc "$1"
}

if [[ ! -d "$APP_DIR/.git" ]]; then
  log "ERROR: $APP_DIR is not a git repository"
  exit 1
fi

exec 9>"$LOCK_FILE"
if ! flock -n 9; then
  log "Another deployment is currently running."
  exit 0
fi

log "Starting deployment for branch '$BRANCH'"

if [[ ! -f "$APP_DIR/.env" && -f "$APP_DIR/.env.example" ]]; then
  cp "$APP_DIR/.env.example" "$APP_DIR/.env"
  chown "$WEB_USER:$WEB_USER" "$APP_DIR/.env"
  log "Created .env from .env.example"
fi

run_as_web_user "cd '$APP_DIR' && git fetch origin --prune"
run_as_web_user "cd '$APP_DIR' && git checkout '$BRANCH'"
run_as_web_user "cd '$APP_DIR' && git pull --ff-only origin '$BRANCH'"

run_as_web_user "cd '$APP_DIR' && composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev"
run_as_web_user "cd '$APP_DIR' && npm install --no-package-lock"
run_as_web_user "cd '$APP_DIR' && npm run build"

if run_as_web_user "cd '$APP_DIR' && grep -q '^APP_KEY=$' .env"; then
  run_as_web_user "cd '$APP_DIR' && php artisan key:generate --force"
fi

run_as_web_user "cd '$APP_DIR' && php artisan migrate --force"
run_as_web_user "cd '$APP_DIR' && php artisan optimize"

chown -R "$WEB_USER:$WEB_USER" "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
find "$APP_DIR/storage" "$APP_DIR/bootstrap/cache" -type d -exec chmod 775 {} +
find "$APP_DIR/storage" "$APP_DIR/bootstrap/cache" -type f -exec chmod 664 {} +

systemctl reload "$PHP_FPM_SERVICE" >/dev/null 2>&1 || true
systemctl reload nginx >/dev/null 2>&1 || true

DEPLOYED_COMMIT="$(run_as_web_user "cd '$APP_DIR' && git rev-parse --short HEAD")"
log "Deployment finished successfully on commit $DEPLOYED_COMMIT"
