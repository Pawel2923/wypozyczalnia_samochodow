FROM php:fpm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory for PHP
WORKDIR /app/public

# Copy app and install composer packages
COPY /app /app
RUN composer install
