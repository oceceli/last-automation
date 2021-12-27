FROM php:7.4-fpm

RUN curl -sS https://getcomposer.org/installer | php -- \
	--install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    nano \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip
RUN docker-php-ext-install gd

WORKDIR /app
COPY . . 
RUN cp .env.example .env

