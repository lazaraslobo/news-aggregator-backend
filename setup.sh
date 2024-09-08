#!/bin/bash

# Adjust ownership and permissions for directories if running on the host system
sudo chown -R $USER:www-data ./storage/
sudo chown -R $USER:www-data ./bootstrap/cache/
sudo chmod -R 775 ./storage/
sudo chmod -R 775 ./bootstrap/cache/
sudo mkdir -p ./storage/logs ./storage/framework/sessions ./bootstrap/cache
sudo chown -R www-data:www-data ./storage ./bootstrap/cache
sudo chmod -R 775 ./storage ./bootstrap/cache
sudo chmod -R g+w ./storage/logs
sudo chmod -R 775 ./

#php artisan config:clear
#php artisan cache:clear
#php artisan view:clear
#php artisan route:clear
php artisan optimize:clear
