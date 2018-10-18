FROM wordpress:latest

# Install wordpress cli
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
chmod +x wp-cli.phar && \
mv wp-cli.phar /usr/local/bin/wp

RUN	export DEBIAN_FRONTEND="noninteractive"
RUN	apt-get update && apt-get install -y mysql-server

RUN mkdir -p /var/lib/mysql /var/run/mysqld \
	&& chown -R mysql:mysql /var/run/mysqld /var/lib/mysql
	
VOLUME /var/lib/mysql

RUN mv /usr/local/bin/docker-entrypoint.sh /usr/local/bin/wordpress-entrypoint.sh

COPY docker-entrypoint.sh /usr/local/bin/
COPY elementor_outside.zip /

RUN chmod +x /usr/local/bin/wordpress-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENV WORDPRESS_DB_HOST=127.0.0.1
ENV WORDPRESS_DB_USER=root
ENV WORDPRESS_DB_PASSWORD=wordpress
ENV WORDPRESS_DB_NAME=wordpress
ENV PROXY_FROM=http://localhost:3001/elementor

ENTRYPOINT ["docker-entrypoint.sh"]