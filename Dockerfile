# php-fpm 镜像，添加了gd mysql mbstring 扩展
FROM php:7.2-fpm
COPY debian9.list /etc/apt/sources.list
RUN rm -rf /etc/apt/sources.list.d && apt-get update && apt-get -y install libpng-dev  libjpeg-dev libjpeg62-turbo-dev libfreetype6-dev && \
apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/  && \
docker-php-ext-install pdo_mysql gd mbstring
CMD ["php-fpm"]
# EXPOSE 9000
