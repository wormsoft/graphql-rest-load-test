FROM zvinger/docker-node-alpine

WORKDIR /app
ADD ./app/package.json /tmp/package.json
COPY ./app/package.json ./app/package-lock.json* /tmp/
RUN cd /tmp && npm install && mkdir -p /app && mv /tmp/node_modules /app/node_modules
ADD ./app /app
ARG SITE_API_HOST
ENV SITE_API_HOST=${SITE_API_HOST}
RUN echo ${SITE_API_HOST} && SITE_API_HOST=${SITE_API_HOST} ADMIN_SOURCE_URL=${SITE_API_HOST}api/site-info/vue-site

CMD npm run build && npm start
