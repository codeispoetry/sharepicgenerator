Sharepicgenerator with Docker and Webpack.

## Installation
 1. Clone this repo with
  ``git clone ...``

 2. Create docker-compose.yml from docker-compose.yml.sample
 
 3. Install npm dependencies with
  ``docker-compose run node sh -c 'npm install'``

 4. Install npm dependencies in dist within node-container
    `cd dist && npm install``

 5. Install composer dependencies with
  ``docker-compose run webserver sh -c 'cd dist && composer install'``

 6. Bring up the project with
 ``docker-compose up -d``

 7. create and edit ini/config.ini

 8. Create empty log.db-file or rsync it from live

 9. Install WordPress via browser#
    1. enter `define('COOKIEPATH','/')` and db-credentials in wp-config.php
  
 9. Run ```make compile``` to compile css and js. (Do this after very branch-checkout, or invoke file-watcher by editing a sass- or js-file)

There is also a Makefile. You can use ``make up`` and ``make install``.

## Usage
Bring up the project (see above) and head to http://127.0.0.1:9000. The portnumber is defined in the _.env-File_.

## Projectstructure 
### code
Every code goes here.

#### code/dist
This directory is to be deployed.

#### code/build
Here reside the Javascript and SCSS-files. They are compiled by Grunt.
### fonts
All font-files are linked into to webserver-container, so that inkscape can use them. Handle webfonts in _code/dist/fonts_ independently from that.

## Code
### assets and fonts
Pictures, logos, webfonts, etc. can be stored here

### assets/css and assets/js
Compiled files. Use _build_-directory to change code.

### tmp
Uploaded files are here as well as the sharepic. Files are deleted regularly.

### persistent
Templates go here. Opposite to /tmp, directory will not be emtied automatically.

# Add new font
- ttf-file should go to fonts-folder
- create woff2 with ``woff2_compress <font.ttf>`` and move it to assets/fonts
- add font-face in fonts.scss
- upload font to server to /usr/share/fonts
- edit font at https://www.glyphrstudio.com/

# Setup picture gallery
1. The structure in tenants/federal/pictures/img needs to be 

```
    'albumname/1.jpeg'
    'albumname/2.jpeg'
    'foodir/A.JPG'
    'foodir/B.JPG'

```

2. Use deployment/scripts/generate_thumbnails.sh as a cronjob in your docker to generate the thumbnails automatically if new pictures are available in tenants/federal/pictures/img

```
   ./deployment/scripts/generate_thumbnails.sh code/dist/tenants/federal/pictures/img

```

3. Use a meta file like 'albumname/meta.ini' or 'foodir/meta.ini' with the following content:
```
    Photographer = "Max Mustermann"
    Tags = "Flowers Green"
```

4. Be happy with your small picture gallery

# Create a new tenant
1. Copy dir code/dist/tenants/federal and rename it
3. Copy code/build/js/federal 
4. Copy code/webpack.tenats/federal.js 

5. Edit in code/webpack.tenants/..js two times 'federal'
2. Edit $tenant in index.php several times. Use Ctrl-F
2. Edit $tenant in log/index.php

2. create section in config.ini for new tenanant
5. edit .htaccess
5. add gallery and pictures to shared_dirs in deploy.php

5. make compile

5. update config.ini on server

# Enable logging
To create or update the downloads-table for logging, log in as Admin-User and download
a sharepic with all the features or the new feature respectivly.