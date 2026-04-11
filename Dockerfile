FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip npm libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-progress --prefer-dist
COPY package.json ./
RUN npm install

COPY . .

RUN mkdir -p public/uploads/users/profile_img public/uploads/users/cover_img \
    && chown -R www-data:www-data public/uploads

EXPOSE 9000

CMD ["php-fpm"]