ARG NGINX_VERSION=""
FROM nginx:${NGINX_VERSION:+${NGINX_VERSION}-}alpine

RUN apk update; \
    apk upgrade;

COPY site.conf /etc/nginx/conf.d/
