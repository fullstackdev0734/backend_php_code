# Weather Forecast App
This app is a Weather forecast app. This app provides you the details of weather like temperature, min temperature, max temperature, humidity, wind speed, wind direction, etc

## Tech
We have two different instances in our app.
    1. For backend API
    2. For Frontend
We are using Laravel 8 at the backend and Angular 11 on the frontend 

## Features
-- Frontend
- In the frontend, Bootstrap 3 integrated with Angular, so the application is fully responsive on all the devices

-- Backend
- In the backend, using Guzzle so we don't have to write untidy CURL code for 3rd party API
- We are using Redis cache whose expiration time is 1 hour so we don't have to hit 3rd party apps multiple times 


## MUST
The PHP version should be 7.3 or greater and we must have redis installed on our local macine, here is the download URL [Redis Library](https://redis.io/download)

## Installation

In the `app` directory, use 
```sh
npm install
```
to install all the required dependencies at the frontend

In `api` directory, use
```sh
composer install
```
to install all the required dependencies at the backend.

## To run the project on your machine
In `app` directory, you need to update your apiUrl in `environment.ts` file (here we are using 'http://localhost:8000/api/').
Now use this command to start your local server
```sh
ng serve
```

In `api` directory, update the API_KEY, API_URL, API_VERSION in the `env` file
Now use his command to start your local API server 
```sh
php artisan serve
```

## To run unit test

use this command to run the unit test in the api directory

```sh
php artisan test
```

## Can be improved
- We can add an option for changing units of temperature, as some of the people like to see the temperature in Fahrenheit and some in Celsius, so we can switch between both
- We can add a force update button to fetch data from API instead of cache


## Visual of the app

![app Screenshot](https://i.ibb.co/XpK6S2G/Screenshot-7.png)