FROM php:7.4-apache

RUN apt-get update && apt-get install -y inkscape ssh ffmpeg webp locales locales-all facedetect zip qrencode libheif-examples woff2

ENV APACHE_DOCUMENT_ROOT=/var/www/html/dist
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get install -y libpcre3-dev libssl-dev librabbitmq-dev sqlite3 gettext
RUN pecl install oauth 
RUN docker-php-ext-enable oauth
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install gettext && docker-php-ext-enable gettext

RUN a2enmod rewrite


# Needed for api for telegram
#RUN apt-get install python-pip -y
#RUN pip install selenium

#RUN apt-get install -y chromium
#RUN wget https://chromedriver.storage.googleapis.com/78.0.3904.105/chromedriver_linux64.zip
#RUN unzip chromedriver_linux64.zip
#RUN chmod +x chromedriver

RUN mkdir /usr/share/fonts/truetype/custom
RUN mkdir /root/scripts

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
