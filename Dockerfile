FROM php:7.4-fpm-alpine

# ENV LD_LIBRARY_PATH=/usr/local/instantclient
# ENV ORACLE_HOME=/usr/local/instantclient

# Comment this to improve stability on "auto deploy" environments
RUN apk update && apk upgrade

# Install basic dependencies
RUN apk -u add bash git

# Install Oracle Instantclient
# RUN apk add --update --no-cache \
#     curl \
#     vim \
#     unzip \
#     g++ \
#     gcc \
#     make \
#     php7-ctype \
#     php7-session \
#     php7-dom \
#     php7-zlib \
#     php7-mbstring \
#     php7-mcrypt \
#     php7-openssl \
#     php7-xml \
#     php7-json \
#     php7-gd \
#     php7-opcache \
#     php7-pdo \
#     php7-iconv \
#     php7-curl \
#     php7-phar \
#     php7-xmlreader \
#     php7-intl \
#     php7-pear \
#     php7-dom \
#     php7-common \
#     php7-tokenizer \
#     php7-fileinfo \
#     gcompat \
#     musl-dev \
#     libaio-dev \
#     libnsl \
#     gettext-dev \
#     automake \
#     libtool \
#     libc6-compat

# RUN apk add wget libarchive-tools && \
#     wget -qO- https://raw.githubusercontent.com/caffeinalab/php-fpm-oci8/master/oracle/instantclient-basic-linux.x64-12.2.0.1.0.zip | bsdtar -xvf- -C /usr/local && \
#     wget -qO- https://raw.githubusercontent.com/caffeinalab/php-fpm-oci8/master/oracle/instantclient-sdk-linux.x64-12.2.0.1.0.zip | bsdtar -xvf-  -C /usr/local && \
#     wget -qO- https://raw.githubusercontent.com/caffeinalab/php-fpm-oci8/master/oracle/instantclient-sqlplus-linux.x64-12.2.0.1.0.zip | bsdtar -xvf- -C /usr/local && \
#     ln -s /usr/local/instantclient_12_2 /${ORACLE_HOME} && \
#     ln -s /${ORACLE_HOME}/libclntsh.so.* /${ORACLE_HOME}/libclntsh.so && \
#     ln -s /${ORACLE_HOME}/libocci.so.* /${ORACLE_HOME}/libocci.so && \
#     ln -s /${ORACLE_HOME}/lib* /usr/lib && \
#     ln -s /${ORACLE_HOME}/sqlplus /usr/bin/sqlplus && \
#     ln -s /usr/lib/libnsl.so.2  /usr/lib/libnsl.so.1 && \
#     ln -s /usr/lib/libnsl.so.2  /${ORACLE_HOME}/libnsl.so.1 && \
#     ln -s /usr/lib/libc.so /usr/lib/libresolv.so.2 && \
#     ln -s /usr/lib/libc.so  /${ORACLE_HOME}/libresolv.so.2 && \
#     docker-php-ext-configure oci8 --with-oci8=instantclient,/usr/local/instantclient && \
#     docker-php-ext-install oci8

# Install PHP extensions
ADD ./.docker/install-php.sh /usr/sbin/install-php.sh
RUN chmod +x /usr/sbin/install-php.sh
RUN /usr/sbin/install-php.sh

# Copy existing application directory contents
COPY ./.docker/*.ini /usr/local/etc/php/conf.d/
COPY . .

# Change current user to www-data
USER www-data

# Expose ports and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
