#!/usr/bin/env bash

# Elevate to root
sudo su

# Install php7
add-apt-repository ppa:ondrej/php

# Update deps
apt-get update

# Install php
apt-get install -y php7.0 php7.0-cli php7.0-curl php7.0-intl php7.0-mcrypt php7.0-json php7.0-dev php-pear
printf "\n" | pecl install mongodb

# Install Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run composer
su - vagrant
cd /vagrant
composer up