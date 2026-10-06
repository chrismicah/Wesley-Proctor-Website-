#!/usr/bin/env bash
set -euo pipefail
archive=${1:?Pass the website archive}
: "${GODADDY_HOST:?Missing GODADDY_HOST}"
: "${GODADDY_USER:?Missing GODADDY_USER}"
: "${GODADDY_SSH_KEY:?Missing GODADDY_SSH_KEY}"
: "${GODADDY_KNOWN_HOSTS:?Missing GODADDY_KNOWN_HOSTS}"
: "${GODADDY_PATH:?Missing GODADDY_PATH}"
[[ "$GODADDY_HOST" =~ ^[a-zA-Z0-9][a-zA-Z0-9.-]+$ ]] || exit 2
[[ "$GODADDY_USER" =~ ^[a-zA-Z0-9_]+$ ]] || exit 2
[[ "$GODADDY_PATH" =~ ^/home/[a-zA-Z0-9_]+/(public_html|[a-zA-Z0-9._/-]+)$ ]] || exit 2
[[ "$GODADDY_PATH" != *'..'* ]] || exit 2
release="${GITHUB_SHA:-local}-${GITHUB_RUN_ID:-$(date +%s)}-${GITHUB_RUN_ATTEMPT:-1}"
[[ "$release" =~ ^[a-zA-Z0-9-]+$ ]] || exit 2
sshdir=$(mktemp -d)
trap 'rm -rf "$sshdir"' EXIT
chmod 700 "$sshdir"
printf '%s\n' "$GODADDY_SSH_KEY" > "$sshdir/key"
printf '%s\n' "$GODADDY_KNOWN_HOSTS" > "$sshdir/known_hosts"
chmod 600 "$sshdir/key" "$sshdir/known_hosts"
opts=(-i "$sshdir/key" -o BatchMode=yes -o IdentitiesOnly=yes -o StrictHostKeyChecking=yes -o "UserKnownHostsFile=$sshdir/known_hosts" -o ConnectTimeout=20)
target="$GODADDY_USER@$GODADDY_HOST"
# Arguments are restricted above. Never disable host-key verification.
ssh "${opts[@]}" "$target" "umask 077; mkdir -p \"\$HOME/.wpe-deploy/$release\""
scp "${opts[@]}" "$archive" "$target:.wpe-deploy/$release/site.tar.gz"
ssh "${opts[@]}" "$target" "bash -s -- '$GODADDY_PATH' '$release'" <<'REMOTE'
set -euo pipefail
umask 077
live=$1
release="$HOME/.wpe-deploy/$2"
[[ -d "$live" && -f "$live/index.html" ]] || { echo 'Document root has no existing homepage'; exit 2; }
live=$(cd "$live" && pwd -P)
release=$(cd "$release" && pwd -P)
# The private backup must never be inside the served document root.
case "$release/" in "$live/"*) echo 'Backup path is inside document root'; exit 2;; esac
mkdir "$release/staged"
tar -xzf "$release/site.tar.gz" -C "$release/staged"
find "$release/staged" -type f -name '*.php' -print0 | xargs -0 -n 1 php -l > "$release/php-check.txt"
# Back up the complete current document root, including host-managed files.
tar -czf "$release/before.tar.gz" -C "$live" .
# Overlay owned runtime files. Preserve unrelated uploads, .htaccess and ACME files.
cp -R "$release/staged/." "$live/"
find "$release/staged" -type f | while IFS= read -r file; do
  relative=${file#"$release/staged/"}
  chmod 644 "$live/$relative"
done
find "$release/staged" -type d | while IFS= read -r folder; do
  relative=${folder#"$release/staged"}
  chmod 755 "$live$relative"
done
printf 'Deployment complete. Backup: %s/before.tar.gz\n' "$release"
REMOTE
