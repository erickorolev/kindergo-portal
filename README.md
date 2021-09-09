# Kindergo Portal

## Installation instructions

On server we use Apache, PHP 8, MySQL 8.

Application uses Laravel 8.

These are the steps to get the app up and running. Once you're using the app, feel free to change any individual parts.

After pulling project, you need to do following:

* Extract the archive and put it in the folder you want
* Run `cp .env.example .env` file to copy example file to `.env`
* Then edit your `.env` file with DB credentials and other settings.
* Create a MySQL database. If you want to use a non-root user, make sure that the user has permissions to create other users and access all databases (or change the DB manager used for mysql to the one that does not create permissions). Add the database name to your `.env`
* Start Redis (it's used as the queue driver — feel free to change this to any other asynchronous driver)
* Run `composer install` command
* Run `php artisan migrate --seed` command. Notice: seed is important, because it will create the first admin user for you.
* Run `php artisan key:generate` command.
* Configure the app URL & domains
    - If you're using Valet, you can go with the default set-up. Just make sure your project is accessible on `portal.test`
    - If you're using php artisan serve, make localhost your central & Nova domain (replace the `portal.test` instances with localhost in .env). Your development tenants will have domains like `foo.localhost` and `bar.localhost`
    - If you're using anything else — the process will be similar to the one to php artisan serve.
* Run `npm install`
* Run `npm run dev`
* If you have file/photo fields, run `php artisan storage:link` command.
* Laravel Sanctum for API Auth: If you are using custom hostname for project other than localhost make sure that value of `SANCTUM_STATEFUL_DOMAINS` variable in `.env` file is the same as your hostname in browser. Example: `SANCTUM_STATEFUL_DOMAINS=portal.kindergo.site`
* Run the queue worker: `php artisan queue:work`

And that's it, go to your domain and login:

Default credentials

Username: `admin@admin.com`

Password: `password`

### Import data from Vtiger

System supports following commands for getting data from Vtiger:

* `php artisan users:receive` - getting all attendants in contacts module of Vtiger. When user created, we send an email with password to user.
* `php artisan children:receive` - getting all children in contacts module in Vtiger.
* `php artisan payments:receive` - import payments from SPPayments module in Vtiger
* `php artisan trips:receive` - Getting trips from vtiger

### Логи
`/storage/logs`
