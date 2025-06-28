FROM php:8.1-apache

# Copier les fichiers du projet dans le dossier web
COPY . /var/www/html/

# Autoriser Apache à écrire dans /data
RUN chmod -R 777 /var/www/html/data

# Activer mod_rewrite si besoin
RUN a2enmod rewrite

EXPOSE 80
