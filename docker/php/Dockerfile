FROM php:8.2-fpm
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install zip and unzip
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libcurl4-openssl-dev pkg-config libssl-dev && \
    apt-get upgrade -y && \
    apt-get install zip unzip -y && \
# Install Composer
   curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
# Install postgresql driver
    apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql
COPY php.ini /usr/local/etc/php/php.ini

RUN apt-get install -y \
    libldap2-dev \
    libicu-dev


RUN docker-php-ext-configure intl && docker-php-ext-install intl

RUN apt-get install -y acl