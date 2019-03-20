ARG NGINX_VERSION=""
FROM nginx:${NGINX_VERSION:+${NGINX_VERSION}-}alpine

COPY site.conf /etc/nginx/conf.d/
