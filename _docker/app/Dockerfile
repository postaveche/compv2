FROM php:7.4-fpm

 #Copy composer.lock and composer.json
#COPY  ./composer.json /var/www/

# Set working directory
WORKDIR /home/comp.md/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl



# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Install PHP extensions

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_mysql zip exif pcntl gd



# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Installing node 12.x
RUN curl -sL https://deb.nodesource.com/setup_21.x| bash -
RUN apt-get install -y nodejs


# Add user for laravel application
#RUN chmod -R 775 /storage
#RUN chmod -R ugo+rw /storage

#RUN chown -R www-dara:www-data /home/dentclub/www
# Copy existing application directory contents
#COPY ./src/. /var/www

# Copy existing application directory permissions
#COPY --chown=www-data:www-data . /home/dentclub/www

# Change current user to www
#USER dentclub

#RUN composer install --no-scripts --no-autoloader

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
