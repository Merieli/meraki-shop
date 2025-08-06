#!/bin/bash

echo "=== Iniciando MerakiShop Container ==="

# Verificar se é necessário gerar chave do Laravel
if [ ! -f /var/www/meraki-shop/.env ]; then
    echo "Arquivo .env não encontrado, criando..."
    cd /var/www/meraki-shop
    cp .env.example .env 2>/dev/null || echo "APP_ENV=production" > .env
    php artisan key:generate --force
fi

# Teste básico do PHP-FPM
echo "Testando configuração do PHP-FPM..."
if ! php-fpm -t; then
    echo "❌ Configuração do PHP-FPM inválida, usando configuração mínima..."
    cp /usr/local/etc/php-fpm-minimal.conf /usr/local/etc/php-fpm.d/zz-docker.conf
fi

echo "=== Iniciando serviços via Supervisor ==="
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf 