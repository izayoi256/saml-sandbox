#!/bin/sh

set -e

if [ -n "${HOST_UID}" -a "${HOST_UID}" != "$(id -u www-data)" ]; then
    usermod -u "${HOST_UID}" www-data
fi

if [ -n "${HOST_GID}" -a "${HOST_GID}" != "$(id -g www-data)" ]; then
    groupmod -g "${HOST_GID}" www-data
fi

exec docker-php-entrypoint "$@"
