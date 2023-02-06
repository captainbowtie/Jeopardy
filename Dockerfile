FROM ubuntu:latest
RUN apt-get update -y
RUN apt-get install -y apache2 php libapache2-mod-php php-mysql
COPY . /var/www/html/
