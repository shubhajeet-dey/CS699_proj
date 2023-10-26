# PDF-Tool

## Setup

To setup the NGINX server, change the PHP-FPM version in the server.config to installed version:
```bash
sudo ./server_setup.sh
```

To set up the necessary Ubuntu packages for this project, run the following command from the project directory:

```bash
sudo xargs apt-get install < ./ubuntu_packages.txt 
```
 \
Now, run the following command from the project directory to create a Python virtual environment and install necessary python packages for the project:

```bash
./setup.sh
```