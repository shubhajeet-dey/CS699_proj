#!/bin/bash

# PostgreSQL server connection details
DB_USER="pdf_admin"
DB_NAME="pdf_tools"
DB_HOST="localhost"
DB_PORT="5432"
DB_PASSWORD="my_world_is_great@699"

# Creating the database and user
sudo -u postgres createuser $DB_USER
sudo -u postgres createdb $DB_NAME
sudo -u postgres psql -c "ALTER USER $DB_USER WITH ENCRYPTED PASSWORD $DB_PASSWORD"
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE $DB_NAME TO $DB_USER"
sudo -u postgres psql -d $DB_NAME -c "GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO $DB_USER"

# Creating the tables
sudo -u postgres psql -d $DB_NAME -f create_tables.sql