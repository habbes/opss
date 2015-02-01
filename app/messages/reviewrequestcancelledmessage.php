<?php
/**
 * message sent to admin and reviewer to notify that review request has been cancelled
 * @author Habbes
 *
 */
class ReviewRequestCancelledMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param ReviewRequest $request
	 * @return ReviewRequestCancelledMessage
	 */
	public static function create($recipient, $request)
	{
		$m = new static();
		$m->setSubject("Review Request Cancelled");
		$m->setUser($recipient);
		switch($recipient->getType()){
			case UserType::ADMIN:
				$m->setMessageFromTemplate("review-request-cancelled-admin",[
					"reviewer" => $request->getReviewer()->getFullName(),
					"title" => $request->getPaper()->getTitle(),
					"identifier" => $request->getPaper()->getIdentifier()
				]);
				$m->attachPaper($request->getPaper());
				break;
			case UserType::ADMIN:
				$m->setMessageFromTemplate("review-request-cancelled-reviewer",[
					"title" => $request->getPaper()->getTitle(),
					"identifier" => $request->getPaper()->getIdentifier()
				]);
		}
		
		
		return $m;
	}
}