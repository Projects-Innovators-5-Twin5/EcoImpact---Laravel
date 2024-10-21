FROM php:8.2-cli-alpine

# Définir le répertoire de travail
WORKDIR /var/www

# Installer des dépendances supplémentaires
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    oniguruma-dev \  
    libxml2-dev \
    nodejs \
    npm \
    bash \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copier Composer depuis l'image officielle de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier votre code source dans l'image
COPY . .

# Installer les dépendances avec Composer
RUN composer install --no-dev --optimize-autoloader

# Installer les dépendances avec npm
RUN npm install

# Exécuter le script de construction (ou dev)
RUN npm run dev

# Générer la clé d'application Laravel
RUN php artisan key:generate

# Changer la propriété des répertoires nécessaires
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Commande par défaut pour démarrer le serveur
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

# Exposer le port 8000
EXPOSE 8000
