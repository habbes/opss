<?php


/**
 * get the environment variable
 * @param  string $var     name of environmnet variable
 * @param  string $default returned if env variable not set
 * @return string value of env variable
 */
function env($var, $default = null)
{
	return isset($_ENV[$var])? $_ENV[$var] : $default;
}

?>