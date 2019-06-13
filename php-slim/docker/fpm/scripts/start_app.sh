#!/usr/bin/env bash

echo "making writable"

cd /var/www && \
    mkdir -p frontend/web/assets && chmod 777 frontend/web/assets && \
    mkdir -p frontend/runtime && chmod 777 frontend/runtime && \
    mkdir -p backend/runtime && chmod 777 backend/runtime && \
    mkdir -p backend/web/assets && chmod 777 backend/web/assets
    mkdir -p common/runtime && chmod 777 common/runtime

echo "starting"

php console/yii app/setup --interactive=0
php-fpm