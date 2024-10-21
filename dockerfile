FROM php:8.2-cli-alpine

WORKDIR /var/www

RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    oniguruma-dev \  # Remplacer libonig-dev par oniguruma-dev
    libxml2-dev \
    nodejs \
    npm \
    bash \  # Installer bash si nécessaire pour certains scripts
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install

RUN npm run dev

RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

EXPOSE 8000
