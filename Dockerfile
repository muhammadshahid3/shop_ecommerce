FROM php:8.2-apache

WORKDIR /var/www/html


RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql


COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN composer install --no-dev --optimize-autoloader


RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache


RUN a2enmod rewrite


EXPOSE 80

CMD ["apache2-foreground"]