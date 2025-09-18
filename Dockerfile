FROM php:8.2-apache

# Active mod_rewrite (utile si tu fais des routes propres)
RUN a2enmod rewrite

# Définit le nouveau DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www

# Remplace les chemins dans la config Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
