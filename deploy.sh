
rm code/dist/tmp/*
rsync -avhz code/dist/ tom@sharepicgenerator.de:/var/www/html/by2020 --delete