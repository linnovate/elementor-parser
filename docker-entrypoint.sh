#!/bin/bash

if [ "$WORDPRESS_DB_HOST" == "localhost" ] || [ "$WORDPRESS_DB_HOST" == "127.0.0.1" ]; then
   
    echo "Start local mysql-server"

    mysqld & 

    sleep 5

    mysql -uroot -e "\
        CREATE DATABASE IF NOT EXISTS $WORDPRESS_DB_NAME ;
        CREATE USER IF NOT EXISTS '$WORDPRESS_DB_USER'@'localhost' IDENTIFIED BY '$WORDPRESS_DB_PASSWORD' ; \
        GRANT ALL PRIVILEGES ON *.* TO '$WORDPRESS_DB_USER'@'localhost' WITH GRANT OPTION ; \
        UPDATE mysql.user SET plugin='mysql_native_password' WHERE User='$WORDPRESS_DB_USER'; \
        UPDATE mysql.user SET authentication_string = PASSWORD('$WORDPRESS_DB_PASSWORD') WHERE User = '$WORDPRESS_DB_USER' AND Host = 'localhost'; \
        FLUSH PRIVILEGES ;";
        
    echo "Started local mysql-server"

fi

# Install wp plugin
echo "Install wp plugin + sleep 12"
(sleep 12 && echo "Install wp plugin is starting ..." && cd /var/www/html && wp core install \
    --admin_user="$WORDPRESS_DB_USER" \
    --admin_password="$WORDPRESS_DB_PASSWORD" \
    --url="http://localhost" \
    --title='elementor' \
    --admin_email='aaa@aaa.com' \
    --skip-email \
    --color \
    --allow-root \
    && wp option update home "$PROXY_FROM" --allow-root \
    ;  wp option update siteurl "$PROXY_FROM" --allow-root \
    ;  wp plugin install elementor --activate --allow-root \
    ;  wp plugin install /elementor_outside.zip --allow-root \
    ;  wp plugin activate elementor_outside --allow-root \
    ; echo "Install wp plugin is Complete!") &

echo "Start wordpress server"
/usr/local/bin/wordpress-entrypoint.sh apache2-foreground