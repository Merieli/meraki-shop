#!/bin/bash

echo "=== Iniciando MerakiShop Container ==="

# Função para testar configuração PHP-FPM
test_phpfpm() {
    echo "Testando configuração PHP-FPM..."
    php-fpm -t
    return $?
}

# Tentar configuração principal
echo "Testando configuração principal do PHP-FPM..."
if test_phpfpm; then
    echo "✅ Configuração principal OK"
else
    echo "❌ Configuração principal falhou, usando configuração mínima..."
    cp /usr/local/etc/php-fpm-minimal.conf /usr/local/etc/php-fpm.d/zz-docker.conf
    
    if test_phpfpm; then
        echo "✅ Configuração mínima OK"
    else
        echo "❌ Ambas configurações falharam!"
        exit 1
    fi
fi

# Verificar se é necessário gerar chave do Laravel
if [ ! -f /var/www/meraki-shop/.env ]; then
    echo "Arquivo .env não encontrado, criando..."
    cd /var/www/meraki-shop
    cp .env.example .env 2>/dev/null || echo "APP_ENV=production" > .env
    php artisan key:generate --force
fi

echo "=== Iniciando serviços via Supervisor ==="
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf 