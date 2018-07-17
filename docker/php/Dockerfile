FROM php:7.2-fpm

# Install git.
RUN apt-get update \
	&& apt-get upgrade \
	&& DEBIAN_FRONTEND=noninteractive \
	&& apt-get install -yq git zlib1g-dev

# Install php modules.
RUN docker-php-ext-install bcmath \
	&& docker-php-ext-enable bcmath \
	&& docker-php-ext-install zip

# Install composer.
ADD https://getcomposer.org/download/1.6.5/composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer
