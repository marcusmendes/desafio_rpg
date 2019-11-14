FROM ubuntu:18.04

LABEL maintainer="Marcus Maciel"

ENV DEBIAN_FRONTEND=noninteractive

ARG git_repository
ARG default_branch

RUN apt-get update \
    && apt-get install -y \
    curl \
    git \
    vim \
    nginx \
    php7.2 \
    php7.2-fpm \
    php7.2-bz2 \
    php7.2-cgi \
    php7.2-cli \
    php7.2-common \
    php7.2-curl \
    php7.2-dba \
    php7.2-dev \
    php7.2-gd \
    php7.2-imap \
    php7.2-intl \
    php7.2-json \
    php7.2-ldap \
    php7.2-mbstring \
    php7.2-mysql \
    php7.2-pgsql \
    php7.2-soap \
    php7.2-sqlite3 \
    php7.2-tidy \
    php7.2-xml \
    php7.2-xmlrpc \
    php7.2-xsl \
    php7.2-zip \
    && apt-get clean

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && rm composer-setup.php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer

# NGINX
RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log
VOLUME ["/var/cache/nginx"]
RUN rm /etc/nginx/sites-available/default
ADD ./default /etc/nginx/sites-available/default

# SSH
COPY ./.ssh /root/.ssh
RUN touch /root/.ssh/know_hosts
# RUN ssh-keyscan bitbucket.org >> /root/.ssh/known_hosts
RUN chmod 400 /root/.ssh/id_rsa

# Clone Project
RUN git clone --branch ${default_branch} ${git_repository} /var/www/html/project

# BUILD
WORKDIR /var/www/html/project/api
COPY ./.env /var/www/html/project/api
COPY ./.env.test /var/www/html/project/api
COPY ./phpunit.xml /var/www/html/project/api

EXPOSE 8000