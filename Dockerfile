# Laravel
FROM jda-infra

# Environtment
ENV APP_DIR=/var/www

# Copy Code
COPY . $APP_DIR
RUN chmod -R 777 $APP_DIR/storage

# Set WorkDir
WORKDIR $APP_DIR

# Expose http
EXPOSE 80

# Instalation App
RUN composer install -vvv
RUN npm install