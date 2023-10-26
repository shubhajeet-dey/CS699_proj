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

# Creating the database and user
sudo -i -u postgres
createdb pdf_tools
createuser pdf_admin
psql
ALTER USER pdf_admin WITH ENCRYPTED PASSWORD 'my_world_is_great@699';
ALTER USER pdf_admin CREATEDB;
GRANT ALL PRIVILEGES ON DATABASE pdf_tools TO pdf_admin;
\q
exit

# Install PHP postgresql extension
sudo apt install php-pgsql

# Server setup complete
echo "~~~~~~~ Server setup Completed! ~~~~~~~"
