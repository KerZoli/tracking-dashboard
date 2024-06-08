FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    vim \
    unzip \
    git

RUN docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY --chown=www-data:www-data . .

# Adjust user permission & group
RUN usermod --uid 1000 www-data
RUN groupmod --gid 1000  www-data

EXPOSE 80

USER 1000

CMD ["apache2-foreground"]
