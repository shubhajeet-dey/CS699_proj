#!/bin/bash

# Installing virtualenv package to create isolated Python 3 virtual environment
python3 -m pip install virtualenv

# Creating virtual environment named venv_proj
python3 -m virtualenv venv_proj

# Activating the environment
source ./venv_proj/bin/activate

# Installing necessary Python packages
python3 -m pip install -r ./pip_requirements.txt