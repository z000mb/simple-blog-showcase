ARG VERSION

# Dev image
FROM nginx:${VERSION} as dev

# Copy nginx config
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Prod image
FROM dev as prod

COPY ./app/public /app/public
