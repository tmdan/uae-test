#FROM ubuntu:latest
#
##Install Cron
#RUN apt-get update && apt-get -y install cron nano
#
#
#
## Add root file in the cron directory
#COPY docker/cron/job /var/cron.d/job
#
## Give execution rights on the cron job
## Create the log file to be able to run tail
## Apply cron job
#RUN chmod 0744 /var/cron.d/job && touch /var/log/cron.log && crontab /var/cron.d/job
#
## Copy existing application directory contents
#COPY app/ /var/www/
#
## Run the command on container startup
#CMD ["cron", "-f"]

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

COPY docker/cron/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/cron/entrypoint.sh /usr/bin/entrypoint.sh
RUN chmod +x /usr/bin/entrypoint.sh

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]