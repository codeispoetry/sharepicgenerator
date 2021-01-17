Sharepicgenerator with Docker and Webpack.

## Installation
 1. Clone this repo with
  ``git clone ...``

 1. Create docker-compose.yml from docker-compose.yml.sample
 
 1. Install npm dependencies with
  ``docker-compose run node sh -c 'npm install'``

1. Install composer dependencies with
  ``docker-compose run webserver sh -c 'cd dist && composer install'``

 1. Bring up the project with
 ``docker-compose up -d``
  
 1. Run ```make compile``` to compile css an js. (Do this after very branch-checkout, or invoke file-watcher by editing a sass- or js-file)

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

### code/node_modules
Are installed by nmp. Nothing to do here. Will not be commited. Use _npm install_ to create folder and its content.

### docker
The Dockerfiles are here. They are referred to from docker-compose.yml.

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

### vendor
SVG.js, jQuery etc. are here. They are placed manually, not by npm.

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
2. Edit $tenant in index.php several times. Use Ctrl-F
2. Edit $tenant in log/index.php
2. create section in config.ini for new tenanant
3. Copy code/build/js/federal 
4. Copy code/webpack.tenats/federal.js and edit two times 'federal'
5. edit .htaccess
5. add gallery and pictures to shared_dirs in deploy.php
5. make compile

# Enable logging
To create or update the downloads-table for logging, log in as Admin-User and download
a sharepic with all the features or the new feature respectivly.