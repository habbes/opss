<?php

/**
 * email sent to review with request to review a paper
 * @author Habbes
 *
 */
class ReviewRequestEmail extends Email
{
	/**
	 * 
	 * @param User $reviewer
	 * @param ReviewRequest $request
	 * @return ReviewRequestEmail
	 */
	public static function create($reviewer, $request)
	{
		$e = new static();
		$e->addUser($reviewer);
		$e->setSubject("Request to review paper");		
		$e->attachFile($request->getPaper()->getFile());
		$e->setBodyFromTemplate("review-request", [
			"name" => $reviewer->getFullName(),
			"title" => $paper->getTitle(),
			"identifier" => $paper->getIdentifier(),
			"acceptLink" => URL_ROOT."/review-request-response?request={$request->getId()}&response=accept",
			"declineLink" => URL_ROOT."/review-request-response?request={$request->getId()}&response=decline"
		]);
		
		return $e;
		
	}
}