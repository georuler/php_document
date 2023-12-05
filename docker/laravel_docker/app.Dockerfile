FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

RUN ln -sf /usr/share/zoneinfo/Asia/Seoul /etc/localtime \
 && sed -i -- 's/^# alias/alias/g' /root/.bashrc \
 && sed -i -- 's/^# export/export/g' /root/.bashrc


RUN apt-get update

# -----------------------------------------------------------------------------
### PHP Extensions Install
# -----------------------------------------------------------------------------
# @see refs https://github.com/m2sh/php7/blob/master/Dockerfile
RUN pecl channel-update pecl.php.net

RUN apt-get install -y \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libxml2-dev \
        zlib1g-dev \
        libzip-dev \
        libonig-dev \
        libfreetype6-dev \
        vim \
        net-tools \
        curl \
 && docker-php-ext-configure gd --with-jpeg=/usr/include --with-freetype \
 && docker-php-ext-install gd \
 && docker-php-ext-install pdo_mysql \
 && docker-php-ext-install mbstring \
 && docker-php-ext-install opcache \
 && docker-php-ext-install soap \
 && docker-php-ext-install zip

# mongodb
RUN apt-get install -y \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev
RUN pecl install mongodb \
 && docker-php-ext-enable mongodb

# imagemagick
RUN apt-get install -y \
        libmagickwand-dev --no-install-recommends
RUN pecl install imagick \
 && docker-php-ext-enable imagick

# SSH2
RUN apt-get install -y libssh2-1-dev
RUN pecl install ssh2-1.3.1 && docker-php-ext-enable ssh2

# ORACLE EXTENSION
RUN apt-get update && apt-get -y install wget libarchive-tools libaio1  && \
    wget -qO- https://raw.githubusercontent.com/caffeinalab/php-fpm-oci8/master/oracle/instantclient-basic-linux.x64-12.2.0.1.0.zip | bsdtar -xvf- -C /usr/local && \
    wget -qO- https://raw.githubusercontent.com/caffeinalab/php-fpm-oci8/master/oracle/instantclient-sdk-linux.x64-12.2.0.1.0.zip | bsdtar -xvf-  -C /usr/local && \
    wget -qO- https://raw.githubusercontent.com/caffeinalab/php-fpm-oci8/master/oracle/instantclient-sqlplus-linux.x64-12.2.0.1.0.zip | bsdtar -xvf- -C /usr/local && \
    ln -s /usr/local/instantclient_12_2 /usr/local/instantclient && \
    ln -s /usr/local/instantclient/libclntsh.so.* /usr/local/instantclient/libclntsh.so && \
    ln -s /usr/local/instantclient/lib* /usr/lib && \
    ln -s /usr/local/instantclient/sqlplus /usr/bin/sqlplus

RUN echo 'instantclient,/usr/local/instantclient/' | pecl install oci8 \
    && docker-php-ext-enable oci8 \
    && docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/usr/local/instantclient \
    && docker-php-ext-install pdo_oci

## nodejs install
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - 
RUN apt-get install -y nodejs

# Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip \
#     git \
#     iputils-ping \ 
#     net-tools

# # Clear cache
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# # Install PHP extensions
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

#RUN chmod -R 777 /var/www/application
#RUN composer create-project laravel/laravel=8.* --prefer-dist application
#RUN composer create-project laravel/laravel --prefer-dist application
#RUN "cd ./application && npm install"

# Set working directory
WORKDIR /var/www

USER $user