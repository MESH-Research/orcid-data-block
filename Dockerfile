FROM wordpress:latest
RUN docker-php-source extract \
    && apt-get update  && apt-get install -y \
        libxslt1.1 \
        libxslt-dev \
    && docker-php-ext-install xsl \
    && docker-php-source delete
