Sharepicgenerator with Docker and Grunt.

## Installation
 1. Clone this repo with
  ``git clone ...``
 
 1. Install dependencies with
  ``docker-compose run grunt sh -c 'npm install'``

 1. Bring up the project with
 ``docker-compose up -d``
  
 1. Create config.json-File from config-sample.json
 
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
Are installed by nmp. Nothing to do here. Will not be commited. Use _npm install_ to create folder.

### docker
The Dockerfile are here. They are referred to from docker-compose.yml.

### fonts
All font-files are linked into to webserver-container, so that inkscape can use them. Handle webfonts in _code/dist/fonts_ independently from that.

## Core
### assets and fonts
Pictures, logos, webfonts, etc. can be stored here

### assets/css and assets/js
Compiled files. Use _build_-directory to change code.

### tmp
Uploaded files are here as well as the sharepic. Files are deleted regularly.

### vendor
SVG.js, jQuery etc. are here. They are placed manually, no by npm to keep dependencies save.


