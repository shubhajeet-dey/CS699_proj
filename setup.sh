#!/bin/bash

# Installing virtualenv package to create isolated Python 3 virtual environment
python3 -m pip install virtualenv

# Creating virtual environment named venv_proj
python3 -m virtualenv venv_proj

# Activating the environment
source ./venv_proj/bin/activate

# Installing necessary Python packages
python3 -m pip install -r ./pip_requirements.txt

# Setting uploads, results and temporary directory
curr_dir=$(pwd)

echo "export UPLOAD_FILES_PATH=\"${curr_dir}/uploads\"; export TEMP_FILES_PATH=\"${curr_dir}/temp\"; export FINAL_FILES_PATH=\"${curr_dir}/final_results\";" >> ./venv_proj/bin/activate

# Setting up directory permissions for NGINX server (user: www-data) to access/write
setfacl -m u:www-data:rwx uploads/
setfacl -R -m u:www-data:rx pdf_scripts/
setfacl -R -m u:www-data:rx venv_proj/
setfacl -m u:www-data:rwx final_results/