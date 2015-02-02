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
		$template = $request->isAccepted()? "review-request-accepted" : "review-request-declined";
		
		$e->setBodyFromTemplate($template, [
				"reviewer" => $request->getReviewer()->getFullName(),
				"title" = $request->getPaper()->getTitle(),
				"identifier" = $request->getPaper()->getIdentifier(),
				"paperLink" = $request->getPaper()->getAbsoluteUrl(),
				"comments" = $request->getResponseText()
		]);
		
		return $e;
	}
}