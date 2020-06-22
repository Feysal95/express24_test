FROM ubuntu:16.04

# Обновляем и ставим необходимые пакеты
RUN apt-get update && apt-get install -y --no-install-recommends \
    wget cron nano mc software-properties-common

RUN wget -qO - https://openresty.org/package/pubkey.gpg | apt-key add -

RUN add-apt-repository -y "deb http://openresty.org/package/ubuntu $(lsb_release -sc) main"

# Обновляем и ставим необходимые пакеты
RUN apt-get update && apt-get install -y --no-install-recommends \
    openresty openresty-opm openresty-restydoc

#Пользователь
ARG USER_UID
ARG USER_GID
RUN export uid=$USER_UID gid=$USER_GID && \
    groupadd -r php_task -g ${gid} && \
    useradd -u ${uid} -r -g php_task -m -d /home/php_task -s /sbin/nologin -c "Docker image user" php_task

RUN mkdir /php_task && \
    chown -R php_task:php_task /php_task && \
    chown -R php_task:php_task /home/php_task

RUN usermod -a -G www-data php_task

# Add additional binaries into PATH for convenience
ENV PATH=$PATH:/usr/local/openresty/luajit/bin/:/usr/local/openresty/nginx/sbin/:/usr/local/openresty/bin/

# TODO: remove any other apt packages?
CMD ["/usr/local/openresty/bin/openresty", "-g", "daemon off;"]