FROM php:8.1

# Set working directory
WORKDIR /var/www

# Update Packages
RUN apt-get -y update && apt-get -y install curl wget make gcc build-essential supervisor

# Setup Supervisor
RUN mkdir -p /var/log/supervisor

RUN docker-php-ext-configure pcntl --enable-pcntl
RUN docker-php-ext-install pcntl pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql pdo

COPY app/ /var/www/

COPY docker/horizon/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]