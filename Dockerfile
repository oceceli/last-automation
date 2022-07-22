FROM php:7.4-fpm

LABEL maintainer="oceceli"

# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
 build-essential \
 libpng-dev \
 libjpeg62-turbo-dev \
 libfreetype6-dev \
 locales \
 zlib1g-dev \
 zip \
 jpegoptim optipng pngquant gifsicle \
 vim \
 libzip-dev \
 unzip \
 nano \
 git \
 libonig-dev \
 curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions for php
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY . .

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]
