#!/bin/bash
# Run scheduler
while [ true ]
do
  php /var/www/artisan horizon
  sleep 60
done