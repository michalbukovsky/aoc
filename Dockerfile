FROM thecodingmachine/php:8.1-v4-apache-node16

USER root
RUN apt-get update -qq && apt-get install -qq -y make
RUN apt-get autoremove && apt-get autoclean

USER docker
