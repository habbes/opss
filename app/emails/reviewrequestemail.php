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
		$e->setBodyFromTemplate("review-request", [
			"name" => $reviewer->getFullName(),
			"title" => $request->getPaper()->getTitle(),
			"identifier" => $request->getPaper()->getIdentifier(),
			"requestLink" => URL_PAPERS."/review-requests/".$request->getId()
		]);
		
		return $e;
		
	}
}