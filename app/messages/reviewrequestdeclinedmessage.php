<?php
/**
 * notification sent to admin when review request is declined
 * @author Habbes
 *
 */
class ReviewRequestDeclinedMessage extends Message
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
		$m->setMessageFromTemplate('review-request-declined',[
				"reviewer" => $request->getReviewer()->getFullName(),
				"title" => $request->getPaper()->getTitle(),
				"identifier" => $request->getPaper()->getIdentifier(),
				"comments" => $request->getResponseText()
		]);
		return $m;
	}
}