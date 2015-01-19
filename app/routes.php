<?php

/**
 * routes mapping url to request handlers
 */
$routes = [
		['^submit\/(\d+)$',"Submit"],
		['^submit\/?$',"Submit"],
                ['^form\/?$',"Test"],
		['^form\/(\d+)$',"Form"],
		['^test\/?$', "Test"],
		['^test\/(\d+)$', "Test"],
		
		
		//this route is used to redirect Atomatically to Researcher if there is a session existing
		['^(?:index|home)?\/?$',"Message"],
		['^messages\/(?:all\/?)?$', "Message"],
		['^messages\/unread\/?$',"Message@getUnread"],
		['^messages\/ajax\/(\d+)\/?$', "Message@ajaxRead"],
		['^messages\/ajax\/new\/?$', "Message@ajaxNew"],
		['^registration\/?$', "Registration"],
		['^login\/?$',"Login"],
		['^logout\/?$',"Logout"],
		['^papers\/submit\/?$', "PaperSubmit"],
		['^papers\/(\w+)\/?$', "papers/Home"],
		['^papers\/(\w+)\/vet\/?$', "papers/Home@handleVetReview"],
		['^papers\/(\w+)\/download\/?$', "papers/Download"],
		['^papers\/(\w+)\/download\/cover\/?$', "papers/Download@downloadCover@post"],
		['^papers\/(\w+)\/edit', "papers/Edit"],
		['^papers\/(\w+)\/details', "papers/Details"],
		['^papers\/(\w+)\/test\/?', "papers/Test"]
		//this route is only used for initial setup to allow an inital admin to sign up
		// after which it should be disabled
		//['^setup\/admin\/?$', "AdminSetup"],
		
		
		
		
	
];