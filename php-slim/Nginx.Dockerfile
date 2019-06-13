FROM nginx:latest

ADD ./app/public /var/www/web

ENV REDIRECT_FROM_DOMAIN www.api.test-case.s4.obvu.ru
ENV BASE_DOMAIN api.test-case.s4.obvu.ru

COPY ./docker/nginx/conf/site.conf /nginx.template.conf

CMD envsubst '$REDIRECT_FROM_DOMAIN:$BASE_DOMAIN:' < /nginx.template.conf > /etc/nginx/conf.d/site.conf && nginx -g "daemon off;"
