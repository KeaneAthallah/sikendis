# Use the official PHP image as base
FROM php:8.1-fpm

# Set working directory inside the container
WORKDIR /var/www/html

# Install necessary extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev  && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install intl  # Install the intl extension

# Ensure the writable directory exists and has correct permissions for www-data user
RUN mkdir -p /var/www/html/writable/session && \
    chown -R www-data:www-data /var/www/html/writable && \
    chmod -R 775 /var/www/html/writable

# Copy project files into the container
COPY . .

# Install Composer (if needed)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 80 to access the app
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]

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

# Create the cache and logs directories
RUN mkdir -p /var/www/html/application/cache \
    && mkdir -p /var/www/html/application/logs

# Set file permissions
RUN chown -R www-data:www-data /var/www/html/application/cache \
    && chown -R www-data:www-data /var/www/html/application/logs

# Create the writable directories and set permissions
RUN mkdir -p /var/www/html/writable/cache \
    && mkdir -p /var/www/html/writable/logs \
    && mkdir -p /var/www/html/writable/uploads \
    && chown -R www-data:www-data /var/www/html/writable

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader



# Expose port 3002
EXPOSE 9000

COPY entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php-fpm"]
