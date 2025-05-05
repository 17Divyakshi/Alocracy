#!/usr/bin/env bash
apt-get update
apt-get install -y apache2 php libapache2-mod-php
cp -r . /var/www/html/
apachectl -D FOREGROUND
