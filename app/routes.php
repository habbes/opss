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
		['^review\-invitation\-declined\/?$', "EmailReviewInvitationDeclined"],
		['^papers\/all\/?$', "Papers"],
		['^papers\/submit\/?$', "PaperSubmit"],
		['^papers\/(\w+)\/?$', "papers/Home"],
		['^papers\/(\w+)\/vet\/?$', "papers/Home@handleVetReview"],
		['^papers\/(\w+)\/download\/?$', "papers/Download"],
		['^papers\/(\w+)\/download\/cover\/?$', "papers/Download@downloadCover"],
		['^papers\/(\w+)\/edit\/?$', "papers/Edit"],
		['^papers\/(\w+)\/edit\/details\/?$', "papers/Edit@handleDetailsChanges"],
		['^papers\/(\w+)\/edit\/files\/?$', "papers/Edit@handleFileChanges"],
		['^papers\/(\w+)\/edit\/add\-author\/?$', "papers/Edit@handleAddAuthor"],
		['^papers\/(\w+)\/resubmit\/?$', "papers/Resubmit"],
		['^papers\/(\w+)\/invite-reviewer\/?$', "papers/InviteReviewer@inviteNewReviewer"],
		['^papers\/(\w+)\/review-request\/?$', "papers/InviteReviewer@sendReviewRequest"],
		['^papers\/(\w+)\/manage-review-request\/?$', "papers/ReviewRequest"],
		['^papers\/(\w+)\/review\/?$', "papers/Review"],
		['^papers\/(\w+)\/history\/?$', "papers/History"],
		['^papers\/(\w+)\/details', "papers/Details"],
		['^papers\/(\w+)\/test\/?', "papers/Test"],
		['^papers\/review-requests\/?$', "ReviewRequests"],
		['^papers\/review-requests\/(\d+)\/?$', "ReviewRequests"],
		//this route is only used for initial setup to allow an inital admin to sign up
		// after which it should be disabled
		//['^setup\/admin\/?$', "AdminSetup"],
		
		
		
		
	
];