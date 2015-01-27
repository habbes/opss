<?php

class ReviewInvitationSentMessage extends Message
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
		$m->setSubject("Review Invitation Sent");
		$m->setUser($recipient);
		$m->setMessageFromTemplate("review-invitation-sent", [
			"name" => $name,
			"email" => $email,
			"title" => $paper->getTitle(),
			"identifier" => $paper->getIdentifier()	
		]);
		$m->attachPaper($paper);
		
		return $m;
	}
}