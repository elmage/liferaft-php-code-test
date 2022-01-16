# Dockerfile
FROM php:7.4-apache

ARG USER
ARG UID

ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli && apachectl restart
RUN a2enmod ssl && \
    a2enmod rewrite && \
    a2enmod macro && \
    a2enmod headers

#RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - && \
#    apt-get install -y zip libzip-dev nodejs

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $UID -d /home/$USER $USER
RUN mkdir -p /home/$USER/.composer && \
    chown -R $USER:$USER /home/$USER

#ADD . /var/www
#ADD ./public /var/www/html
WORKDIR /var/www

USER $USER

EXPOSE 80

#CMD ["composer", "install"]
#CMD ["npm", "install"]
#CMD ["npm", "run", "dev"]
#CMD ["php", "artisan", "serve", "--port=80"]
