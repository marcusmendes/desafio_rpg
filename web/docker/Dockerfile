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
    nginx-extras

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs

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
WORKDIR /var/www/html/project/web
RUN npm install && npm run build

EXPOSE 80
