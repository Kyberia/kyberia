#!/usr/bin/zsh

set -x

/usr/bin/mysqld_pre_systemd
/usr/sbin/mysqld  --validate-password=OFF --pid-file=/var/run/mysqld/mysqld.pid $@ || echo "Failed"
