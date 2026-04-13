FROM php:8.4-apache

# --------------------------------------------------
# System + build dependencies
# --------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    pkg-config \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libmagickwand-dev \
    imagemagick \
    autoconf \
    gcc \
    g++ \
    make \
    re2c \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# PHP extensions
# --------------------------------------------------
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# --------------------------------------------------
# Imagick (explicit version for PHP 8.4)
# --------------------------------------------------
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# --------------------------------------------------
# Remove build deps (keep image smaller)
# --------------------------------------------------
RUN apt-get purge -y \
    autoconf \
    gcc \
    g++ \
    make \
    re2c \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# Node.js + npm (Debian way — stable)
# --------------------------------------------------
RUN apt-get update && apt-get install -y \
    nodejs \
    npm \
    && npm install -g npm \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# Apache
# --------------------------------------------------
RUN a2enmod rewrite headers

# --------------------------------------------------
# Composer
# --------------------------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --------------------------------------------------
# App
# --------------------------------------------------
WORKDIR /var/www/html
COPY --chown=www-data:www-data . /var/www/html

RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

CMD ["apachectl", "-D", "FOREGROUND"]
