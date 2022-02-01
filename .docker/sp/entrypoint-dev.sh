#!/bin/sh

set -e

ini=$(cat << EOS
xdebug.client_host=${XDEBUG_HOST:-$(ip route | awk 'NR==1 {print $3}')}
xdebug.client_port=${XDEBUG_PORT}
EOS
)
echo "${ini}" > /usr/local/etc/php/conf.d/xdebug-client.ini

exec /entrypoint-base.sh "$@"
