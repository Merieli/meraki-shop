# Informa um valor padrão para a versão do PHP caso não seja passado
ARG PHP_VERSION=8.3.20-fpm-alpine3.20

FROM node:22-alpine AS node-stage

FROM php:${PHP_VERSION}

ARG USER_NAME
ARG UID=1000
ARG GID=1000
# Adiciona o nome do projeto recebido com compose ou define o padrão como `app`
ARG PROJECT_NAME=app

# Diretório da aplicação
ENV APP_DIR="/var/www/${PROJECT_NAME}"

# --------------------------------------------------------------
# Instalação de dependências do sistema operacional
# --------------------------------------------------------------
RUN apk update && apk add --no-cache \
    supervisor \
    zlib-dev \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    unzip \
    postgresql-dev \
    curl \
    make \
    gnu-libiconv-dev \
    oniguruma-dev

# --------------------------------------------------------------
# EXTENSÕES DO PHP
# --------------------------------------------------------------    
# Instala extensões do PHP: mysqli, pdo, pdo_mysql, pdo_pgsql, pgsql, session, xml
RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql session xml

# Instala extensões do PHP: zip, simplexml, pcntl, gd, fileinfo e mbstring
RUN docker-php-ext-install zip simplexml pcntl gd fileinfo mbstring

# --------------------------------------------------------------    
# Instala a última versão do Composer para o PHP
# --------------------------------------------------------------    
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# --------------------------------------------------------------
# Prepara as configurações customizadas do PHP da pasta `/.docker/php`
# --------------------------------------------------------------
COPY ./.docker/php/php.ini "$PHP_INI_DIR/conf.d/99_extra.ini"
COPY ./.docker/php/php-fpm.conf /usr/local/etc/php-fpm.d

# --------------------------------------------------------------
# Prepara o usuário - para resolver problemas de permissão ao alterar arquivos
# --------------------------------------------------------------
RUN addgroup -g ${GID} ${USER_NAME} \
    && adduser -D -u ${UID} -G ${USER_NAME} -s /bin/sh -h /home/${USER_NAME} ${USER_NAME}

# --------------------------------------------------------------
WORKDIR $APP_DIR

# Altera o proprietário e o grupo do diretório da aplicação - definido pela variável $APP_DIR
RUN chown ${USER_NAME}:${USER_NAME} $APP_DIR

# Copio tudo que está na pasta para dentro do container usando o usuário
COPY --chown=${USER_NAME}:${USER_NAME} . .

# --------------------------------------------------------------
# Remove as dependências antigas e instala as novas do composer
# --------------------------------------------------------------
RUN [ -d "vendor" ] && rm -rf vendor || true

# --------------------------------------------------------------
# Cria alias para executar o comando do Composer
# Alias `cmp` que executa o comando `composer`
# --------------------------------------------------------------
RUN echo '#!/bin/sh' > /usr/local/bin/cmp && \
    echo 'composer "$@"' >> /usr/local/bin/cmp && \
    chmod +x /usr/local/bin/cmp

# --------------------------------------------------------------
# Instala o Node para os comandos do npm
# --------------------------------------------------------------
COPY --from=node-stage /usr/local/bin/node /usr/local/bin/
COPY --from=node-stage /usr/local/lib/node_modules /usr/local/lib/node_modules

# Cria os links simbólicos como root (antes de mudar para usuário não-root)
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm && \
    ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

RUN npm install -g npm@latest

# --------------------------------------------------------------
# Instala o Laravel
# --------------------------------------------------------------
USER ${USER_NAME}

RUN composer global require laravel/installer

# Adiciona o diretório bin do composer ao PATH para o usuário
ENV PATH="/home/${USER_NAME}/.composer/vendor/bin:${PATH}"

USER $USER_NAME
