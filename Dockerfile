# Dockerfile
FROM wordpress:6.6-php8.2-apache

# mod_rewrite
RUN a2enmod rewrite

# install tools and Xdebug
RUN apt-get update && apt-get install -y \
    less vim zip unzip curl git \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && rm -rf /var/lib/apt/lists/*

# Configure Apache to allow .htaccess overrides
RUN sed -ri 's!/var/www/html>!/var/www/html>\n\tAllowOverride All!g' /etc/apache2/apache2.conf

# Copy Xdebug configuration file (remove these two lines if not needed)
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
