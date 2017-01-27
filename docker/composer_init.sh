#!/usr/bin/zsh -l

set -e

cd /kyberia
[[ ! -f app/config/parameters.yml ]] && cp docker/app_parameters.yml app/config/parameters.yml
mkdir -p var/cache/{dev,prod}

while [[ ! -S /var/lib/mysql/mysql.sock ]] { sleep 1 }

composer.phar install

chown -R apache:apache var/cache/* var/{logs,sessions}
