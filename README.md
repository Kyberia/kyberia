# Kyberia

[![Gemnasium](https://img.shields.io/gemnasium/Kyberia/kyberia.svg)](https://gemnasium.com/github.com/Kyberia/kyberia)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/Kyberia/kyberia.svg)](https://scrutinizer-ci.com/g/Kyberia/kyberia/)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/Kyberia/kyberia.svg)](https://scrutinizer-ci.com/g/Kyberia/kyberia/)
[![Code Climate](https://img.shields.io/codeclimate/github/Kyberia/kyberia.svg)](https://codeclimate.com/github/Kyberia/kyberia)

## Docker for local kyberia development

This image is based on CentOS 7.x which is compatible with Red Hat 7.x.
Percona Server for MySQL 5.7 is used as the database server.

Building the image requires a database dump, which will be imported while
building. Put `kyberia-db.sql` into the `data` directory and build the
image.

Build the kyberia image named `kyberia/www`:
```
docker build --rm -t kyberia/www .
```

From a docker image, you can create multiple containers, which are like an
instance of an image. Only one container will be usually needed for
kyberia development.

Create and start the container named `kyberia`:
```
mkdir -p mysqld-socket
docker run \
    --name kyberia \
    -v mysqld-socket:/var/run/mysqld \
    -v $PWD:/kyberia \
    -e TERM=$TERM -ti kyberia/www
```
