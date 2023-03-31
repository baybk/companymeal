# Build project
### Step 1.1: run: `composer install`
### Step 1.2: run: `npm install`
### Step 1.3: run: `npm run dev`

### Step 1.4: run: `php artisan migrate`
### Step 1.5: run: `php artisan db:seed --class=UserTableSeeder`

### Step 1.6: run: `php artisan serve` to view web
## Step 1.7: Seed data:
`php artisan db:seed --class=UsertableSeeder`

# Deploy heroku:
## login heroku CLI if not yet: `sudo heroku auth:login`
## access run bash: `sudo heroku run bash -a=companymeal`
## push code to server: 2 method: You can go to dashboard of Heroku see the current deploy method


FOR DOCKER:

# How to build this Laravel project ?
You can build this project base on Docker.

## Prerequisites
1. Firstly, you need to install Docker
2. You should config Docker File Sharing, to include the path of project folder

## Build
1. Unzip source code. Then `cd` to project folder `companymeal`
2. Copy content of `.env.example` to `.env` file
3. Run command: `docker-compose up -d --build`
4. Run command: `docker-compose run --rm app composer install`, to install the dependencies ...
  Note: If any errors appear, consider to run: `docker-compose run --rm app composer update`

5. Create the database and migrate: `docker-compose run --rm app php artisan migrate`
6. Make sample data to test: `docker-compose run --rm app php artisan db:seed --class=DatabaseSeeder`
7. Generate Docs Swagger: `docker-compose run --rm app php artisan l5-swagger:generate`
   Note: if any errors appear, consider to comment the line 31 in file: vendor/zircote/swagger-php/src/Loggers/DefaultLogger.php:31
         and run Generate Docs Swagger again
8. Access link `http://localhost:8000`, to check the website
   + Click to tab `Summarize Database/Api`, you can see my answer for the problem
   + Click to tab `Apis Docs`, you can see some apis and call them to see the responses 
   + Click to tab `Login`, if you want to Login as a user (testing account: user@gmail.com / 123456) 
   + Tabs `Recommended`, `Top Page`, `My Record`, I show some testing data with basic UI
   + Click Click to tab `Logout`, if you want to Logout


## Summarize Database/API:
In case you cannot build this project, you can check my answer in PDF file: `ArentTest-Answer.pdf`


