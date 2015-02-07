<?php

class ReviewRequestResponseEmail extends Email
{
	/**
	 * 
	 * @param User $recipient
	 * @param ReviewRequest $request
	 * @return ReviewRequestResponseEmail
	 */
	public static function create($recipient, $request)
	{
		$e = new static();
		$e->addUser($recipient);
		$reviewer = $request->getReviewer()->getFullName();
		if($request->isAccepted()){
			$template = "review-request-accepted";
			$e->setSubject("Review Request Accepted");
		}
		else {
			$template = "review-request-declined";
			$e->setSubject("Review Request Declined");
		}
		
		$e->setBodyFromTemplate($template, [
				"name" => $recipient->getFullName(),
				"reviewer" => $request->getReviewer()->getFullName(),
				"title" => $request->getPaper()->getTitle(),
				"identifier" => $request->getPaper()->getIdentifier(),
				"paperLink" => $request->getPaper()->getAbsoluteUrl(),
				"comments" => $request->getResponseText()
		]);
		
		return $e;
	}
}