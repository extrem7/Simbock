<p align="center">
    <img src="http://simbock.com/dist/img/logo.svg" width="600">
</p>


Let's work together with *Simboсk* - Volunteering job any industry, any location, any experience level - We are here to
make the world a better place

----------

## Installation

Please check the official laravel installation guide for server requirements before you start.
[Official Documentation](https://laravel.com/docs/master)

- Clone the repository `git clone git@gitlab.com:Sheshlyuk/simbok.git`
- Switch to the repo folder
- Install all the dependencies using composer and npm
- Copy the example env file and make the required configuration changes in the .env file
- Generate a new application key
- Run the database migrations (**Set the database connection in .env before migrating**)
- Run `npm run prod`
- Start the local development server
- Run the database seeder and you're done `php artisan db:seed`

# Code overview

## Main dependencies

### PHP

Name | version
--- | --- | 
laravel/framework | ^7.24
nwidart/laravel-modules | ^7.1
coderello/laravel-shared-data | ^2.0
beyondcode/laravel-websockets | ^1.9 |

### JS

Name | version
--- | --- |
bootstrap-vue | ^2.2.2
vue | ^2.5.17
vue-stripe-checkout | ^3.5.14-beta.0

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application
fully working.
