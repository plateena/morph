#!/bin/sh

cd /var/www/vue/src

npm run build

# Execute the CMD passed to the Docker container
exec "$@"
