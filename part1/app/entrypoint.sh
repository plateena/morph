#!/bin/sh

# Adjust permissions for the storage directory
chown -R www-data:www-data storage
chmod -R 775 storage

php artisan migrate

# Execute the CMD passed to the Docker container
exec "$@"
