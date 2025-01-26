#!/bin/bash
chown -R www-data:www-data /var/www/html/writable
exec "$@" # Execute the original command (Apache)