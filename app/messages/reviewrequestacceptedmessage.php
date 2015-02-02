<?php
/**
 * notification sent to admin when review request is accpeted
 * @author Habbes
 *
 */
class ReviewRequestAcceptedMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param ReviewRequest $request
	 * @return ReviewRequestDeclinedMessage
	 */
	public static function create($recipient, $request)
	{
		$m = new static();
		$m->setUser($recipient);
		$m->setSubject("Review Request Declined");
		$m->attachPaper($request->getPaper());
		$m->setMessageFromTemplate('review-request-accepted',[
				"reviewer" => $request->getReviewer()->getFullName(),
				"title" => $request->getPaper()->getTitle(),
				"identifier" => $request->getPaper()->getIdentifier()
		]);
		return $m;
	}
}