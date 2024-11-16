# Базовый образ с PHP и Composer
FROM php:8.2-fpm

# Установка необходимых зависимостей
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    libonig-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка прав на папку storage и bootstrap/cache
WORKDIR /var/www
RUN chown -R www-data:www-data /var/www

# Копирование проекта в контейнер
COPY . /var/www

# Установка зависимостей Laravel
RUN composer install

RUN chmod -R 775 storage bootstrap/cache
