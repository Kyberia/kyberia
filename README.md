# Kyberia

[![Gemnasium](https://img.shields.io/gemnasium/Kyberia/kyberia.svg)](https://gemnasium.com/github.com/Kyberia/kyberia)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/Kyberia/kyberia.svg)](https://scrutinizer-ci.com/g/Kyberia/kyberia/)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/Kyberia/kyberia.svg)](https://scrutinizer-ci.com/g/Kyberia/kyberia/)
[![Code Climate](https://img.shields.io/codeclimate/github/Kyberia/kyberia.svg)](https://codeclimate.com/github/Kyberia/kyberia)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/be359dbe-f1de-42de-a24e-f45970e0250e.svg)](https://insight.sensiolabs.com/projects/be359dbe-f1de-42de-a24e-f45970e0250e)

<!-- vim-markdown-toc GFM -->
* [Docker for local kyberia development](#docker-for-local-kyberia-development)
  * [Building the kyberia docker image](#building-the-kyberia-docker-image)
  * [Create the kyberia container](#create-the-kyberia-container)
  * [Start the kyberia container](#start-the-kyberia-container)
  * [Obtain shell access](#obtain-shell-access)
* [Project directory structure](#project-directory-structure)
* [Webpack](#webpack)

<!-- vim-markdown-toc -->

## Docker for local kyberia development

This image is based on CentOS 7.x which is compatible with Red Hat 7.x.
Percona Server for MySQL 5.7 is used as the database server.

Docker workflow is as following:

1. Build the kyberia docker image.
2. Create a kyberia docker container from the image.
   No kyberia container is running yet.
3. Start the kyberia container. Container can be started at background
   with no visible console messages, or as an interactive container.
   You can stop the container in similar way. Stopping the container does
   not destroy it. You can start it up again. Filesystem changes inside
   of the container are persistent and visible the next time the container
   starts.
4. At this point, apache and mysql database are running. Kyberia source code
   directory is shared with the running container. Any change in the source
   code is visible to the container as well. This is done by docker volume
   functionality, whereby the source code directory is "mounted" as a volume
   into the container.
5. If necessary, a shell access can be obtained to an already running container.

### Building the kyberia docker image

Building the image requires a database dump, which will be imported while
building. Put `kyberia-db.sql` into the `data` directory and build the
image.

Build the kyberia image named `kyberia/www`:
```
docker build --rm -t kyberia/www .
```

### Create the kyberia container

From a docker image, you can create multiple containers, which are like an
instance of an image. Only one container will be usually needed for
kyberia development.

Create the container named `kyberia`:
```
mkdir -p mysqld-socket
docker create \
    --name kyberia \
    -v mysqld-socket:/var/run/mysqld \
    -v $PWD:/kyberia \
    -e TERM=$TERM -ti kyberia/www
```

### Start the kyberia container

Starting the container is as simple as typing `docker start kyberia`,
which start the container at background. In order to start it at foreground,
type `docker start -ia kyberia`

### Obtain shell access

Shell access to an already running container can be obtained by typing
`docker exec -ti kyberia zsh -l`


## Project directory structure

```
.
├── app
│   ├── Resources   # twig templates & main.js for JS assets
│   └── config      # config related to building & bundling (webpack, doctrine, Symfony)
├── bin             # TBD
├── data            # folder that contains initial SQL dump
├── docker          # config files for docker images
├── mysqld-socket   # TBD
├── node_modules    # (downloaded) JS dependencies via npm/yarn
├── src             # source code
├── tests           # source code tests
├── var             # TBD
│   ├── cache       # (populated in runtime)
│   ├── logs        # (populated in runtime)
│   └── sessions    # (populated in runtime)
├── vendor          # (downloaded) PHP depdendencies via composer
└── web             # www ROOT
    ├── css         # Webpack output - styles: main + vendor
    ├── fonts       # Webpack output - fonts
    ├── images      # Webpack output - referenced images
    └── js          # Webpack output - JavaScript: - main + vendor
```

## Webpack

  * this projects uses [Webpack2](https://webpack.js.org/) loading & bundling front-end assets (js, css, fonts, images, etc)
  * outputs bundles to destination directory `<rootDir>/web` + folder based on bundle type
  * 3 profiles
    * `npm start` will run [webpack-dev-server](https://github.com/webpack/webpack-dev-server)
    * `npm run build:dev` creates development bundles - non-minified, without hashes 
    * `npm run build:prod` creates production bundles

## Swagger 

  * Kyberia API is described in `api-description.yml` file
  * you can edit online - [swagger editor](http://editor.swagger.io)
  * you can edit locally - `docker run -p 8080:8080 swaggerapi/swagger-editor`
