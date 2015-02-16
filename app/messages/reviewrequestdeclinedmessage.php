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
		switch($recipient->getType()){
			case UserType::ADMIN:
				$m->attachPaper($request->getPaper());
				$template = "review-request-declined-admin";
				break;
			case UserType::REVIEWER:
				$template = "review-request-declined-reviewer";
		}
		
		$m->setMessageFromTemplate($template,[
				"reviewer" => $request->getReviewer()->getFullName(),
				"title" => $request->getPaper()->getTitle(),
				"identifier" => $request->getPaper()->getIdentifier(),
				"comments" => $request->getResponseText()
		]);
		return $m;
	}
}