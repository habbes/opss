# README #

## AERC OPSS ##

* Paper submission system for the AERC
* [Current Production Site](http://aercopss.newmark.co.ke)

## Setup Environment ##

* Clone the repo: `git clone https://habbes@bitbucket.org/habbes/aerc_opss.git`
* You need [Composer](https://getcomposer.org/doc/00-intro.md) installed.
* Run `composer install` in the root directory
* Create a `.env` file from the `.env.example` template
* Properly set the DB and SMTP config settings in `.env` according to your environment
* Create the database from `aerc_opss.sql` schema in the project root

### Document Root and Rewrite ###
You must configure the `RewriteBase` option in `.htaccess` file and the `URL_ROOT_SUBPATH`
option in `.env` according to whether or not you're running the site in document root.

If you're running in document root (e.g. directly under `http://localhost`), leave them
empty. If you're running the site in a subdirectory in document root, then set the
subdirectory as the value of the options, with a leading forward slash.
Example: if you the site in `localhost/opss` then you must set the value of `RewriteBase`
and `.htaccess` to `/opss`.

### Setup Admin ###
You will need to setup at least one Admin to properly use the site. A user cannot register
himself as Admin, without invitation from an existing admin. To register the first admin
* Open the `app/routes.php` file
* Find the last route in the list, the route for `setup/admin` and uncomment that line
* This will make the `setup/admin` route accessible
* Visit that url i.e. `http://<base_url>/setup/admin` and create an Admin account
* Comment out that route again to disable direct admin registration

## Project Structure ##


## Contribution guidelines ##

* Create a new branch for your code changes
* Push that branch after committing the changes
* I'll pull them in master and upload them to the site

### Contact Me ###

* Email: haby_habbes@live.com
* Tel: 0726166685