FROM ubuntu:latest

#Install Cron
RUN apt-get update && apt-get -y install cron nano



# Add root file in the cron directory
COPY docker/cron/job /var/cron.d/job

# Give execution rights on the cron job
# Create the log file to be able to run tail
# Apply cron job
RUN chmod 0744 /var/cron.d/job && touch /var/log/cron.log && crontab /var/cron.d/job

# Copy existing application directory contents
COPY app/ /var/www/

# Run the command on container startup
CMD ["cron", "-f"]