<?php

/**
 * message to notify that a review request has been sent to a reviewer
 * @author Habbes
 *
 */
class ReviewRequestSentMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param ReviewRequest $request
	 * @return ReviewRequestSent
	 */
	public static function create($recipient, $request)
	{
		$m = new static();
		$m->setUser($recipient);
		$m->setSubject("Review Request Sent");
		
		$paper = $request->getPaper();
		switch($recipient->getType()){
			case UserType::ADMIN:
				$m->setSubject("Review Request Sent");
				$m->setMessageFromTemplate("review-request-sent-admin",[
					"reviewer" => $request->getReviewer()->getFullName(),
					"title" => $paper->getTitle(),
					"identifier" => $paper->getIdentifier(),
					"author" => $paper->getResearcher()->getFullName(),
				]);
				$m->attachPaper($paper);
				break;
			case UserType::REVIEWER:
				$m->setSubject("Review Request");
				$m->setMessageFromTemplate("review-request-sent-reviewer",[
						"title" => $paper->getTitle(),
						"identifier" => $paper->getIdentifier()
				]);
				$m->attachReviewRequest($request);
				break;
		}
		
		return $m;
	}
}