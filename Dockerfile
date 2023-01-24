FROM ubuntu:20.04

COPY build /var/www/_build

RUN apt update -y
RUN apt install gnupg wget software-properties-common -y
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y tzdata
RUN add-apt-repository ppa:ondrej/php
RUN apt-get install apache2 php8.1 php8.1-cli php8.1-curl php8.1-common php8.1-opcache php8.1-mysql php8.1-mbstring php8.1-mcrypt php8.1-zip php8.1-fpm php8.1-redis php8.1-xml unzip gnupg2 curl -y
RUN a2enmod rewrite headers expires proxy_fcgi setenvif
RUN a2enconf php8.1-fpm

RUN touch /var/tmp/fpm.log && chown www-data /var/tmp/fpm.log
RUN touch /var/log/php8.1-fpm.log  && chmod +r /var/log/php8.1-fpm.log

RUN curl -sS https://getcomposer.org/installer | php

RUN rm /var/www/html/index.html -f

WORKDIR /var/www/src

CMD php /var/www/_build/setup.php && service php8.1-fpm start && service apache2 start && tail -f /dev/null
EXPOSE 80
