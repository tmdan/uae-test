FROM php:8.1-fpm

# Copy composer.lock and composer.json
#COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

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
    curl\
    supervisor \
    libonig-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
#RUN docker-php-ext-install mbstring zip exif pcntl mysqli pdo pdo_mysql
RUN docker-php-ext-install pdo mbstring gd pdo_mysql
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-enable pdo_mysql pdo

# Install redis
RUN pecl install redis && docker-php-ext-enable redis

# Install pcntl extention for laravel horizon  - https://dev.to/kakisoft/php-docker-how-to-enable-pcntlprocess-control-extensions-1afk
RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#copy php.ini
COPY docker/app/php/conf.d/local.ini /usr/local/etc/php/conf.d/local.ini

# Copy existing application directory contents
COPY app/ /var/www/

RUN addgroup -gid 1000 -system www && \
    useradd -g 1000 www && \
    chmod 775 -R ./

RUN chown -R www:www /var/www/storage
RUN chmod -R 777 /var/www/storage
RUN chmod -R 777 storage bootstrap/cache
RUN chmod -R 777 ./

# Add user for laravel application
USER www

EXPOSE 9000

CMD ["php-fpm"]
