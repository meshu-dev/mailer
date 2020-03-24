# Mailer App

A small app used to send e-mails from the contact form of my portfolio website using the Slim PHP framework.

This app could be expanded upon to send e-mails for other apps when required.

## Install software (using Mac and brew)

  - Install composer 
```
brew install composer
```

  - Install PHP
```
brew install php
```

## Setup app

  - Run composer to install dependancies
```
cd ~/mailer
composer install
```
  - Create an .env via the .env.example file then fill in the config parameters
```
cd ~/mailer
cp .env.example .env 
vim .env
```
  - Use composer to run application
```
cd ~/mailer
composer run-script start
```
  - Go to localhost:8080 (can be changed in composer.json)

  [http://localhost:8080](http://localhost:8080)

