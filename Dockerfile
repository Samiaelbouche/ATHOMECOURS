FROM php:8.2-apache


RUN a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql

ENV APACHE_DOCUMENT_ROOT /var/www

# Remplace les chemins dans la config Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
