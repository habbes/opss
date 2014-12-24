<?php

/**
 * routes mapping url to request handlers
 */
$routes = [
		['^submit\/(\d+)$',"Submit"],
		['^submit\/?$',"Submit"],
                ['^form\/?$',"Form"],
		['^form\/(\d+)$',"Form"],
		['^test\/?$', "Test"],
		['^test\/(\d+)$', "Test"],
		['^registration\/?$', "Registration"],
		['^/?$',"Login"],
];