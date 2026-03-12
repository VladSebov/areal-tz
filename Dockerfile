FROM php:8.5-apache
COPY ./src/ .
RUN docker-php-ext-install mysqli
EXPOSE 80