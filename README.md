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

The root contains the a few files and folders

* __index.php__, the starting point, loads necessary files and bootstraps the application
* __database.sql__ is the mysql dump of the database structure
* __.env__ contains environment variable settings (you should create this from .env.example template)
* __.htaccess__ this does the url rewriting
* __app/__ contains the main application files
* __vendor/__ contains external libraries installed with composer
* __static/__ contains static assets (js, css, etc.), they are accessible through the url /public
* __composer__ composer dependencies

The __app__ folder is where most of the code is written. It contains the core classes of the system, which are store in the __core__ folder. These are the core of the framework and could be used in other applications. You should not change these files. The __config__ directory stores the configurations file. The __data__ directory stores dynamically uploaded data files, such as submitted papers, profile photos, etc. The __messages__ directory stores classes used to create notification messages. The __emails__ directory stores classes used to create email messages.The __sys_data__ directory stores files used to generate options such as country lists, language lists, etc. The app folder also contains the __routes.php__ which registers all the url routes and their associated handlers.

If you want to create custom helper or base classes, store them in the __custom__ directory.

### MVC ###

The system is loosely based on an MVC architecure. The request cycle starts from the index.php file, which creates an instance of an Application (defined in app/core/application.php) passing the url request. The application searches through the routes listed in `routes.php`, when it finds a matching route, it passes the request to the associated `RequestHandler`. The RequestHandler is set to handler GET or POST requests (or both) and return a response, mostly through a `View`. A View loads and combines various templates to which it passes data from the RequestHandler to create a complete response that is sent back to the browser.

To create a request handler, create a subclass of `RequestHandler` in the __handlers__ directory. The name of the file must match the name of the class in lowercase. Example: `class MyHandler extends RequestHandler`. The base `RequestHandler` is defined in app/core/requesthandler.php.
To create a view, create a subclass of `View`in the __views__ folder. Example: `class MyView extends View`. The base `View` is defined in app/core/view.php

You can find, and add, reusable subclasses of `RequestHandler` and `View` in the __custom__ folder.

## Contribution guidelines ##

* Create a new branch for your code changes
* Push that branch after committing the changes
* I'll pull them in master and upload them to the site

### Contact Me ###

* Email: haby_habbes@live.com
* Tel: 0726166685