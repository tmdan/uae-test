FROM ubuntu:16.04

# Set working directory
WORKDIR /var/www

RUN apt-get update && apt-get install -y openssh-server apache2 supervisor
RUN mkdir -p /var/lock/apache2 /var/run/apache2 /var/run/sshd /var/log/supervisor


#copy php.ini
COPY docker/app/php/conf.d/local.ini /usr/local/etc/php/conf.d/local.ini

#supervisior
COPY docker/cron-supervisor/conf.d/  /etc/supervisor/conf.d/

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

COPY docker/cron-supervisor/conf.d/  /etc/supervisor/conf.d/

EXPOSE 22 80
CMD ["/usr/bin/supervisord"]