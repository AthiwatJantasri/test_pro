FROM php:8.2-cli

USER root

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    wget \
    libpq-dev \
    libssl1.1 \
    && docker-php-ext-install pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER vscode
