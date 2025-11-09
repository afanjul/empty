FROM php:8.4-fpm-alpine

# Instalar dependencias del sistema
RUN apk add --no-cache \
    bash \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make \
    openssl-dev \
    libxml2-dev

# Configurar extensiones GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instalar extensiones PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring \
    zip \
    intl \
    gd \
    bcmath \
    opcache \
    soap

# Instalar Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Limpiar cache de APK
RUN rm -rf /var/cache/apk/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Configurar permisos
RUN addgroup -g 1000 www && \
    adduser -D -u 1000 -G www www && \
    chown -R www:www /var/www/html

# Cambiar a usuario no privilegiado
USER www

# Exponer puerto PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
