#!/bin/bash

php-fpm8.1 -D && \
nginx -g 'daemon off;'