FROM php:7.2-fpm 

# Обновляем и ставим необходимые пакеты
RUN apt-get update && apt-get install -y --no-install-recommends \
    gnupg apt-utils ssh unzip git nano libtool libicu-dev cron screen mariadb-client \
    vim iputils-ping wget zip htop strace

#Ставим расширения
#RUN docker-php-ext-install -j$(nproc) pcntl mysqli intl
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Обновляем PECL
RUN pecl channel-update pecl.php.net

# Ставим redis и xdebug
RUN pecl install -o -f redis xdebug \
    &&  rm -rf /tmp/pear

# composer
ENV PATH "/composer/vendor/bin:$PATH"
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
RUN curl --silent --fail --location --retry 3 --output /tmp/installer.php --url https://getcomposer.org/installer \
 && php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer \
 && composer --ansi --version --no-interaction \
 && rm -rf /tmp/* /tmp/.htaccess

#Пользователь
ARG USER_UID
ARG USER_GID
RUN export uid=$USER_UID gid=$USER_GID && \
    groupadd -r php_task -g ${gid} && \
    useradd -u ${uid} -r -g php_task -m -d /home/php_task -s /sbin/nologin -c "Docker image user" php_task

RUN mkdir /php_task && \
    chown -R php_task:php_task /php_task && \
    chown -R php_task:php_task /composer

RUN usermod -a -G www-data php_task

ADD script/my.cnf /home/php_task/.my.cnf

RUN chown -R php_task:php_task /home/php_task

USER php_task
