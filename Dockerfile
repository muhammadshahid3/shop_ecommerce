FROM php:8.2-apache

WORKDIR /var/www/html

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Apache rewrite enable
RUN a2enmod rewrite

# Apache document root public set
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Laravel files copy
COPY . .

# Composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]