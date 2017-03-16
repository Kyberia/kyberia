#!/usr/bin/zsh -l

set -e

composer_init.sh
npm_update.sh

cd /kyberia
npm run build:dev
