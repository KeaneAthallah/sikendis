# Use an official PHP runtime as a parent image
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    libmariadb-dev-compat \
    nano && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (including mysqli)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mysqli zip intl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy the CodeIgniter application
COPY . /var/www/html

# Create writable and repository directories, set permissions
RUN mkdir -p /var/www/html/application/cache \
    /var/www/html/application/logs \
    /var/www/html/writable/cache \
    /var/www/html/writable/logs \
    /var/www/html/writable/uploads \
    /var/www/html/public/repository/kendaraan \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Copy entrypoint script and set execution permissions
COPY entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php-fpm"]
