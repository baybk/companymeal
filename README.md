# Build project
## Step 1: setup as Laravel project
## Step 2: Seed data:
`php artisan db:seed --class=UsertableSeeder`

# Deploy heroku:
## login heroku CLI if not yet: `sudo heroku auth:login`
## access run bash: `sudo heroku run bash -a=companymeal`
## push code to server: 2 method: You can go to dashboard of Heroku see the current deploy method