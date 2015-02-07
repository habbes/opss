<?php

class ReviewSubmittedEmail extends Email
{
	/**
	 * 
	 * @param User $recipient
	 * @param Review $review
	 * @return ReviewSubmittedEmail
	 */
	public static function create($recipient, $review)
	{
		$e = new static();
		$e->addUser($recipient);
		$e->setSubject("Review Submitted");
		$e->setBodyFromTemplate("review-submitted", [
				"name" => $recipient->getFullName(),
				"reviewer" => $review->getReviewer()->getFullName(),
				"title" => $review->getPaper()->getTitle(),
				"identifier" => $review->getPaper()->getIdentifier(),
				"paperLink" => $review->getPaper()->getAbsoluteUrl(),
				"recommendation" => Review::getVerdictString($review->getRecommendation())
		]);
		
		return $e;
	}
}