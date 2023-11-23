#!/bin/bash

# Installing NGINX server
sudo apt install nginx

# Starting the service
sudo systemctl start nginx

# Installing PHP-FPM is a PHP FastCGI Process Manager
sudo apt install php-fpm

# Changing the default nginx root directory to php_files/
php_files_path="$(pwd)/php_files"

# Learned that / is not mandatory delimeter, can use in this way! (+  is the new delimeter)
sed -i "s+/home/striker/Desktop/CS699_proj/php_files+$php_files_path+" server.config

# Copying the config to NGINX config
sudo cp server.config /etc/nginx/sites-available/default

# Restart NGINX server
sudo systemctl restart nginx

# Installing postgresql
sudo apt install postgresql postgresql-contrib

# Install PHP postgresql extension
sudo apt install php-pgsql

# Run Database setup scripts
sudo ./database_setup.sh

# Server setup complete
echo "~~~~~~~ Server setup Completed! ~~~~~~~"
