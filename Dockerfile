FROM php:8.4.27-apache

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
# Imagick
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
# Node.js + npm (NodeSource, includes npm)
# --------------------------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
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
# Match www-data to your WSL user (uid/gid 1000)
# so files created in the container are owned by you
# --------------------------------------------------
RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data \
    && chown -R www-data:www-data /var/www

# --------------------------------------------------
# App (mounted from the host via docker-compose)
# --------------------------------------------------
WORKDIR /var/www/html

CMD ["apachectl", "-D", "FOREGROUND"]