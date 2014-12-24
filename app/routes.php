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
		
		//this route is used to redirect Atomatically to Researcher if there is a session existing
		['^\/?$',"Researcher"],
		
		['^login\/?$',"Login"],
		['^researcher\/?$',"Researcher"],
		['^researcher\/(\.+)?$',"Researcher"],
];