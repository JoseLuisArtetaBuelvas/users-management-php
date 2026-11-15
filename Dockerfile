# ================================================================
# CRUD Usuarios / Universidades — imagen para Render
# PHP 8.3 + Apache con mod_rewrite (usa el .htaccess del proyecto)
# y los drivers PDO de MySQL y PostgreSQL (Supabase).
# ================================================================
FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql \
    && apt-get purge -y --auto-remove \
    && rm -rf /var/lib/apt/lists/*

# Configuración de PHP para producción (sin mostrar errores al usuario)
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# .htaccess necesita mod_rewrite y AllowOverride All
RUN a2enmod rewrite \
    && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Render inyecta PORT (por defecto 10000); en local se usa 80.
ENV PORT=80
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
