<?php

/**
 * message sent to reviewer as a reminder to respond to a review request
 * @author Habbes
 *
 */
class ReviewRequestReminderMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param ReviewRequest $request
	 * @return ReviewRequestReminderMessage
	 */
	public static function create($recipient, $request)
	{
		$m = new static();
		$m->setUser($recipient);
		$m->setSubject("Review Request Reminder");
		$m->attachReviewRequest($request);
		$m->setMessageFromTemplate("review-request-reminder", [
				"title" => $request->getPaper()->getTitle(),
				"identifier" => $request->getPaper()->getIdentifier(),
				"date" => Utils::siteDateFormat($request->getDateSent())
		]);
		
		return $m;
	}
}