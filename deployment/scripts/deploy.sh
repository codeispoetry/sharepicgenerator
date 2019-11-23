
rm /var/www/html/dist/tmp/*
rsync -avhz /var/www/html/dist/ tom@sharepicgenerator.de:/var/www/html/by2020 --delete