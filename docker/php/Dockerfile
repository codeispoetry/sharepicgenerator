FROM php:7.2-apache

RUN apt-get update && apt-get install -y inkscape ssh rsync wget unzip sudo

RUN apt-get install python-pip -y
RUN pip install selenium

RUN apt-get install -y chromium
#RUN wget https://chromedriver.storage.googleapis.com/78.0.3904.105/chromedriver_linux64.zip
#RUN unzip chromedriver_linux64.zip
#RUN chmod +x chromedriver

RUN mkdir /usr/share/fonts/truetype/custom
RUN mkdir /root/.ssh
RUN mkdir /root/scripts
