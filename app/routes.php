<?php

/**
 * routes mapping url to request handlers
 */
$routes = [
		['^submit\/(\d+)$',"Submit"],
		['^submit\/?$',"Submit"],
                ['^form\/?$',"Index"],
		['^form\/(\d+)$',"Form"],
		['^test\/?$', "Test"],
		['^test\/(\d+)$', "Test"],
		
		
		//this route is used to redirect Atomatically to Researcher if there is a session existing
		['^(?:index|home)?\/?$',"Home"],
		['^registration\/?$', "Registration"],
		['^login\/?$',"Login"],
		['^logout\/?$',"Logout"],
		
	
];