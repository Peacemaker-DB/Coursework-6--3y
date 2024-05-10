FROM php:8.1-fpm

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
    curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash 
RUN apt-get update && apt-get install -y nodejs

RUN cd /var/www && composer install

COPY . /var/www

RUN chown -R www-data:www-data /var/www
RUN chmod 755 /var/www

RUN composer install

FROM node:22-slim
RUN npm install npm@latest -g

WORKDIR /var/www
COPY composer.json ./


CMD php artisan serve --host=0.0.0.0 --port=8181

EXPOSE 8181
