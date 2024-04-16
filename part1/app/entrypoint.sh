#!/bin/sh

# Adjust permissions for the storage directory
chown -R www-data:www-data storage
chmod -R 775 storage

# Execute the CMD passed to the Docker container
exec "$@"
