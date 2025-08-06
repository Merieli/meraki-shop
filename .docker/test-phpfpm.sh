#!/bin/bash

echo "=== Testando configuração PHP-FPM ==="

echo "1. Verificando sintaxe da configuração..."
php-fpm -t

echo "2. Verificando se o usuário www-data existe..."
id www-data

echo "3. Verificando diretórios de log..."
ls -la /var/log/ | grep php

echo "4. Testando inicialização do PHP-FPM em modo de teste..."
timeout 10s php-fpm -F &
PHP_PID=$!

sleep 5

if kill -0 $PHP_PID 2>/dev/null; then
    echo "✅ PHP-FPM iniciou com sucesso!"
    kill $PHP_PID
else
    echo "❌ PHP-FPM falhou ao iniciar"
fi

echo "5. Verificando configuração PHP..."
php -m | head -10

echo "=== Fim do teste ===" 