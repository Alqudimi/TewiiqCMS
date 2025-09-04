FROM php:8.2-apache

# تثبيت امتدادات PHP المطلوبة
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring exif pcntl bcmath opcache

# تفعيل mod_rewrite
RUN a2enmod rewrite

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات التطبيق
WORKDIR /var/www/html
COPY TewiiqPHP/ ./

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 uploads/ \
    && chmod -R 777 database/ \
    && chmod 666 database/tewiiq.db

# تثبيت التبعيات باستخدام Composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80

