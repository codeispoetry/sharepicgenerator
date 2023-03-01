Sharepicgenerator with Docker and Gulp.

## Installation
 1. Clone this repo 
 2. Create docker-compose.yml from docker-compose.yml.sample
 
 3. Install npm dependencies with
  ``docker-compose run node sh -c 'npm install'``

 4. Install npm dependencies in dist within node-container
    ``cd dist && npm install``

 5. Install composer dependencies with
  ``docker-compose run webserver sh -c 'cd dist && composer install'``

 6. Bring up the project with
 ``docker-compose up -d``

 7. create and edit ini/config.ini

 8. Create empty log.db-file or rsync it from live

 9. Run ```make compile``` to compile css and js. (Do this after very branch-checkout, or invoke file-watcher by editing a sass- or js-file)

There is also a Makefile. You can use ``make up`` and ``make install``.

## Usage
Bring up the project (see above) and head to http://127.0.0.1:9000. The portnumber is defined in the _.env-File_.

## Adding new fonts
All fonts go to _dist/assets/typefaces.
Place here both the ttf/otf file and the woff2-file.

- create woff2 with ``woff2_compress <font.ttf>`` 
- edit font at https://www.glyphrstudio.com/

## Creating a new tenant automatically
1. make tenant-create
2. create section in config.ini for new tenanant
5. edit .htaccess

5. update config.ini on server

# Tests
In directory _code_ run
```npx playwright test```