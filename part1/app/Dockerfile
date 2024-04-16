# Use Alpine Linux as base image
FROM php:8.1-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install additional dependencies
RUN apk update && apk add --no-cache \
    bash \
    curl \
    libxml2-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    zlib-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-webp --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy entrypoint script into the container
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Make entrypoint script executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Expose port 9000 to communicate with Nginx
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
