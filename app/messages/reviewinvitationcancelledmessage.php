<?php

class ReviewInvitationCancelledMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param Paper $paper
	 * @param string $name
	 * @param string $email
	 * @return ReviewInvitationSentMessage
	 */
	public static function create($recipient, $paper, $name, $email)
	{
		$m = new static();
		$m->setSubject("Review Invitation Cancelled");
		$m->setUser($recipient);
		$m->setMessageFromTemplate("review-invitation-cancelled", [
			"name" => $name,
			"email" => $email,
			"title" => $paper->getTitle(),
			"identifier" => $paper->getIdentifier()	
		]);
		$m->attachPaper($paper);
		
		return $m;
	}
}