
rsync -avhz --exclude log/log.txt --exclude log/countsharepics.txt --exclude tmp /var/www/html/dist/ tom@sharepicgenerator.de:/var/www/html/v4 --delete