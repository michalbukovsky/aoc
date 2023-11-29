FROM thecodingmachine/php:8.2-v4-apache

USER root
RUN apt-get update -qq && apt-get install -qq -y make
RUN apt-get autoremove && apt-get autoclean

USER docker
