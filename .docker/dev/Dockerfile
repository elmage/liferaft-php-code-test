# Dockerfile
FROM php:7.4-apache

RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-enable pdo_mysql && apachectl restart \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod ssl && \
    a2enmod rewrite && \
    a2enmod macro && \
    a2enmod headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG UID

#update apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

#install nvm
ENV NVM_DIR /root/.nvm
RUN mkdir $NVM_DIR
RUN curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.39.1/install.sh | bash
ENV NODE_VERSION v16.3.0

RUN . $NVM_DIR/nvm.sh && nvm install $NODE_VERSION && nvm alias default $NODE_VERSION && nvm use default

ENV NODE_PATH $NVM_DIR/versions/node/$NODE_VERSION/lib/node_modules
ENV PATH      $NVM_DIR/versions/node/$NODE_VERSION/bin:$PATH

# Create app directory
WORKDIR /var/www

RUN echo "Copying Dependencies..."
COPY ./package.json ./package.json
COPY ./package-lock.json ./package-lock.json
COPY ./composer.json ./composer.json
COPY ./composer.lock ./composer.lock

# Install Dependencies
RUN echo "Installing Dependencies..."
RUN npm i

COPY . .
RUN composer install
RUN npm run dev

EXPOSE 80
