<?php

//on production server, set this to empty string
define("URL_ROOT_SUBPATH", "/aerc_opss");

define("URL_ROOT", "http://" . $_SERVER['SERVER_NAME'] . URL_ROOT_SUBPATH);