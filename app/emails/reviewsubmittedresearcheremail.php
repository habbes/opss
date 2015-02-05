<?php

/**
 * email sent to researcher after admin has forwarded review
 * @author Habbes
 *
 */
class ReviewSubmittedResearcherEmail extends Email
{
	/**
	 * 
	 * @param User $recipient
	 * @param Review $review
	 * @return ReviewSubmittedResearcherEmail
	 */
	public static function create($recipient, $review)
	{
		$e = new static();
		$e->addUser($recipient);
		$e->setSubject("Review Submitted");
		$paper = $review->getPaper();
		$e->setBodyFromTemplate("review-submitted-researcher",[
			"name" => $recipient->getFullname(),
			"title"	=> $paper->getTitle(),
			"identifier" => $paper->getIdentifier(),
			"paperLink" => $paper->getAbsoluteUrl(),
			"reviewLink" => $paper->getAbsoluteUrl()."/reviews",
			"verdict" => Review::getVerdictString($review->getAdminVerdict())
		]);
		return $e;
	}
}