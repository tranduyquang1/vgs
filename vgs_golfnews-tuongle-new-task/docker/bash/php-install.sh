cd /var/www/html && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.16
php /usr/local/bin/composer install
php-fpm

exec $@