# Run Apache Insatll
FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
RUN yarn
# # Run Node.js
# FROM node:15

# WORKDIR /app

# COPY package.json .
# RUN npm install

# COPY . ./
# EXPOSE 3000

# CMD ["node", "index.js"]