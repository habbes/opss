<?php

require_once "vendor/autoload.php";

// load environment variables from .env file
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.env')){
	$envLoader = new josegonzalez\Dotenv\Loader(__DIR__. DIRECTORY_SEPARATOR . '.env');
	$envLoader->parse()->toEnv();
}

require_once "app/helpers.php";
require_once "app/dirs.php";
require_once "app/autoload.php";
require_once "app/routes.php";
require_once "app/urls.php";

$url = isset($_GET['url'])? $_GET['url'] : '';

$app = new Application($url, $routes);
$app->start();