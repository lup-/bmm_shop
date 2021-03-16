FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y -q --no-install-recommends \
        libxml2-dev \
        libz-dev \
        libjpeg-dev \
        libpng-dev \
        libwebp-dev \
        libfreetype6-dev \
        libssl-dev \
        libfreetype6-dev \
        libonig-dev \
        libmcrypt-dev \
        msmtp \
        gettext \
        wget \
        screen && \
    apt-get clean && \
    rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure gd \
                --prefix=/usr \
                --with-jpeg \
                --with-webp \
                --with-freetype && \
        docker-php-ext-install gd && docker-php-ext-enable gd && \
        php -r 'var_dump(gd_info());' && \
    docker-php-ext-install mysqli mysqli pdo pdo_mysql mbstring tokenizer iconv && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    pecl install mcrypt && docker-php-ext-enable mcrypt