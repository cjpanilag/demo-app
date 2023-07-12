FROM php:8.1.0-fpm

RUN apt-get update && apt-get install -y \
    gnupg2 \
    ca-certificates \
    apt-transport-https \
    software-properties-common \
    wget \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    p7zip-full \
    curl \
    git

RUN wget https://nginx.org/keys/nginx_signing.key && apt-key add nginx_signing.key
RUN echo "deb http://nginx.org/packages/debian/ $(lsb_release -cs) nginx" | tee /etc/apt/sources.list.d/nginx.list
RUN apt-get update && apt-get install -y nginx

RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www/html

COPY . /var/www/html

RUN docker-php-ext-install pdo_mysql zip

#RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD service nginx start && php-fpm
