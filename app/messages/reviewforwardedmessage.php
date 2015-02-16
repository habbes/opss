<?php
/**
 * message sent to admin and researcher when admin forwards a review to the researcher
 * @author Habbes
 *
 */
class ReviewForwardedMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param Review $review
	 * @return ReviewForwardedMessage
	 */
	public static function create($recipient, $review)
	{
		$m  = new static();
		$m->setUser($recipient);
		$paper = $review->getPaper();
		$verdict = Review::getVerdictString($review->getAdminVerdict());
		switch($recipient->getType()){
			case UserType::RESEARCHER:
				$m->setSubject("Review Submitted");
				$m->setMessageFromTemplate("review-forwarded-researcher", [
					"title" => $paper->getTitle(),
					"identifier" => $paper->getIdentifier(),
					"verdict" => $verdict
				]);
				break;
			case UserType::ADMIN:
				$m->setSubject("Review Forwarded to Researcher");
				$m->setMessageFromTemplate("review-forwarded-admin",[
					"title" => $paper->getTitle(),
					"identifier" => $paper->getIdentifier(),
					"verdict" => $verdict,
					"researcher" => $paper->getResearcher()->getFullName()
				]);
				break;
		}
		
		return $m;
	}
}