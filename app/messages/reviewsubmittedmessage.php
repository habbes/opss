<?php

class ReviewSubmittedMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param Review $review
	 * @return ReviewSubmittedMessage
	 */
	public static function create($recipient, $review)
	{
		$m = new static();
		$m->setUser($recipient);
		$m->setSubject("Review Submitted");
		$title = $review->getPaper()->getTitle();
		$identifier = $review->getPaper()->getIdentifier();
		$recommendation = Review::getVerdictString($review->getRecommendation());
		switch($recipient->getType()){
			case UserType::ADMIN:
				$m->attachPaper($review->getPaper());
				$m->setMessageFromTemplate("review-submitted-admin", [
						"reviewer" => $review->getReviewer()->getFullName(),
						"title" => $title,
						"identifier" => $identifier,
						"recommendation" => $recommendation
				]);
				break;
			case UserType::REVIEWER:
				$m->setMessageFromTemplate("review-submitted-reviewer",[
					"title" => $title,
					"identifier" => $identifier,
					"recommendation" => $recommendation
				]);
		}
	
		return $m;
	}
}