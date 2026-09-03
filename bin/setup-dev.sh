#!/usr/bin/env bash
# Install WordPress and activate the Ramadan plugin in the Docker environment.
set -euo pipefail

cd "$(dirname "$0")/.."

WP_PORT="${WP_PORT:-9080}"
ADMIN_USER="${ADMIN_USER:-admin}"
ADMIN_PASS="${ADMIN_PASS:-admin}"
ADMIN_EMAIL="${ADMIN_EMAIL:-admin@example.com}"

docker compose up -d --wait wordpress

docker compose run --rm wpcli wp core install \
	--url="http://localhost:${WP_PORT}" \
	--title="Ramadan Dev" \
	--admin_user="${ADMIN_USER}" \
	--admin_password="${ADMIN_PASS}" \
	--admin_email="${ADMIN_EMAIL}" \
	--skip-email

docker compose run --rm wpcli wp plugin activate ramadan

echo
echo "Site:      http://localhost:${WP_PORT}"
echo "Admin:     http://localhost:${WP_PORT}/wp-admin (${ADMIN_USER} / ${ADMIN_PASS})"
echo "phpMyAdmin: http://localhost:${PMA_PORT:-9081}"
