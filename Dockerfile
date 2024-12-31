# Use an official PHP image with Apache
FROM php:8.1-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Update package lists and install required dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring

# Copy project files into the container
COPY . /var/www/html

# Expose port 80 for the application
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
