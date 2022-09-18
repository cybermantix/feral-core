FROM php:8.1-cli-alpine

# #########
# VARIABLES
# #########
ENV DEVUSER developer
ENV DEVWORKDIR /opt/app
ENV DEVBASEDIR .
ENV COMPOSER_HOME /opt/app/composer


# ###########
# OS PACKAGES
# ###########
RUN apk update && \
    apk upgrade && \
    apk add \
        bash \
        git \
        figlet \
        icu-dev \
        libzip-dev \
        libsodium-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        libsodium-dev \
        libwebp-dev \
        freetype-dev \
        zip

# #############
# CONFIGURE PHP
# #############
RUN docker-php-ext-configure zip && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp

# #############
# INSTALL PHP
# #############
RUN docker-php-ext-install \
    exif \
    opcache \
    pdo_mysql \
    gd \
    sodium \
    intl \
    zip

# #############
# COMPOSER
# #############
COPY --from=composer:2.1 /usr/bin/composer /usr/local/bin/composer

# ##############################
# ADD THE USER TO THE IMAGE
# ##############################
WORKDIR ${DEVWORKDIR}
RUN addgroup -g 1688 ${DEVUSER} && \
    adduser -D -s "/bin/sh" -g "Great Developer" -G ${DEVUSER} ${DEVUSER} && \
    mkdir /var/run/php-fpm/ && \
    chown ${DEVUSER}:${DEVUSER} /var/run/php-fpm ..

# ############
# DEVELOPMENT
# ############
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
USER ${DEVUSER}

ENV PATH=$DEVWORKDIR/docker/bin:$PATH

ENTRYPOINT ["startup"]