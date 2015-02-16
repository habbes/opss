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
		['^papers\/?$', "Papers"],
		['^papers\/submit\/?$', "PaperSubmit"],
		['^papers\/(\w+)\/?$', "papers/Home"],
		['^papers\/(\w+)\/vet\/?$', "papers/Home@handleVetReview"],
		['^papers\/(\w+)\/download\/?$', "papers/Download"],
		['^papers\/(\w+)\/download\/cover\/?$', "papers/Download@downloadCover"],
		['^papers\/(\w+)\/download\/version\/(\d+)\/?$', "papers/Download@downloadPaperVersion"],
		['^papers\/(\w+)\/download\/cover\/version\/(\d+)\/?$', "papers/Download@downloadCoverVersion"],
		['^papers\/(\w+)\/edit\/?$', "papers/Edit"],
		['^papers\/(\w+)\/edit\/details\/?$', "papers/Edit@handleDetailsChanges"],
		['^papers\/(\w+)\/edit\/files\/?$', "papers/Edit@handleFileChanges"],
		['^papers\/(\w+)\/edit\/add\-author\/?$', "papers/Edit@handleAddAuthor"],
		['^papers\/(\w+)\/resubmit\/?$', "papers/Resubmit"],
		['^papers\/(\w+)\/invite-reviewer\/?$', "papers/InviteReviewer@inviteNewReviewer"],
		['^papers\/(\w+)\/review-request\/?$', "papers/InviteReviewer@sendReviewRequest"],
		['^papers\/(\w+)\/manage-review-request\/?$', "papers/ReviewRequest"],
		['^papers\/(\w+)\/reviews\/?$', "papers/Reviews"],
		['^papers\/(\w+)\/reviews\/(\d+)\/?$', "papers/Reviews"],
		['^papers\/(\w+)\/reviews\/(\d+)\/file-admin\/?$', "papers/Reviews@downloadFileToAdmin"],
		['^papers\/(\w+)\/reviews\/(\d+)\/admin-file\/?$', "papers/Reviews@downloadAdminFile"],
		['^papers\/(\w+)\/reviews\/(\d+)\/file-author\/?$', "papers/Reviews@downloadFileToAuthor"],
		['^papers\/(\w+)\/review\/?$', "papers/Review"],
		['^papers\/(\w+)\/review-submitted\/?$', "papers/ReviewSubmitted"],
		['^papers\/(\w+)\/review-submitted\/file-admin\/?$', "papers/ReviewSubmitted@downloadFileToAdmin"],
		['^papers\/(\w+)\/review-submitted\/file-author\/?$', "papers/ReviewSubmitted@downloadFileToAuthor"],
		['^papers\/(\w+)\/schedule-workshop\/?$', "papers/ScheduleWorkshop"],
		['^papers\/(\w+)\/workshop-review\/?$', "papers/Workshop"],
		['^papers\/(\w+)\/remove-from-workshop\/?$', "papers/Workshop@removeFromQueue"],
		['^papers\/(\w+)\/post-workshop-review-min\/?$', "papers/PostWorkshopReviewMin"],
		['^papers\/(\w+)\/send-to-comms\/?$', "papers/SendToComms"],
		['^papers\/(\w+)\/history\/?$', "papers/History"],
		['^papers\/(\w+)\/details', "papers/Details"],
		['^papers\/(\w+)\/test\/?', "papers/Test"],
		['^papers\/review-requests\/?$', "ReviewRequests"],
		['^papers\/review-requests\/(\d+)\/?$', "ReviewRequests"],
		['^papers\/review-requests\/(\d+)\/download-paper\/?$', "ReviewRequests@downloadPaper"],
		['^admins\/?$','Users@getAdmins'],
		['^reviewers\/?$','Users@getReviewers'],
		['^researchers\/?$','Users@getResearchers'],
		['^users\/(\w+)\/?$', 'users/Home'],
		['^users\/(\w+)\/papers-submitted\/?$', 'users/PapersSubmitted'],
		['^workshops\/schedule\/?$', "ScheduleWorkshop"],
		['^workshops\/all\/?$', "AllWorkshops"],
		['^workshops\/?$', "AllWorkshops"],
		['^workshops\/(\w+)-(\d+)\/?$', "WorkshopPapers"],
		//this route is only used for initial setup to allow an inital admin to sign up
		// after which it should be disabled
		['^setup\/admin\/?$', "AdminSetup"],
		
		
		
	
];