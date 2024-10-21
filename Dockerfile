# Imagen base para PHP y Node.js
FROM php:8.3-fpm

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo mbstring gd pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Node.js y npm
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Establecer el directorio de trabajo en /var/www
WORKDIR /var/www

# Copiar todos los archivos al contenedor
COPY . .

# Instalar las extensiones de PHP requeridas
RUN docker-php-ext-install bcmath zip

# Instalar dependencias del backend (PHP)
RUN composer self-update
RUN composer clear-cache
RUN composer update --no-scripts --prefer-dist
RUN composer install --no-scripts --prefer-dist

# Instalar dependencias del frontend (Node.js)
RUN npm install

# Compilar assets del frontend
RUN npm run build

# Permitir permisos de escritura al storage y bootstrap
RUN chmod -R 777 storage bootstrap/cache

# Exponer los puertos 8000 y 5173
EXPOSE 8000 5173

# Comando para ejecutar Laravel y frontend simultáneamente
#CMD php artisan migrate:refresh --seed & npm run dev & php artisan serve --host=0.0.0.0 --port=8000
#CMD php artisan migrate:refresh --seed