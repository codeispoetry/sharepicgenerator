FROM php:7.2-apache

RUN apt-get update && apt-get install -y inkscape ssh rsync wget zip unzip sudo ffmpeg inotify-tools webp

ENV APACHE_DOCUMENT_ROOT=/var/www/html/dist
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get install -y libpcre3-dev libssl-dev librabbitmq-dev
RUN pecl install oauth 
RUN docker-php-ext-enable oauth

RUN apt-get install python-pip -y
RUN pip install selenium

RUN apt-get install -y chromium
#RUN wget https://chromedriver.storage.googleapis.com/78.0.3904.105/chromedriver_linux64.zip
#RUN unzip chromedriver_linux64.zip
#RUN chmod +x chromedriver

RUN mkdir /usr/share/fonts/truetype/custom
RUN mkdir /root/.ssh
RUN mkdir /root/scripts
