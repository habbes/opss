<?php

class ReviewInvitationDeclinedMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param RegInvitation $invitation
	 */
	public static function create($recipient, $invitation)
	{
		$m = new static();
		$m->setSubject("Review Invitation Declined");
		$m->setUser($recipient);
		$m->setMessageFromTemplate("review-invitation-declined"[
			"name" => $invitation->getName(),
			"email" => $invitation->getEmail(),
			"title" => $invitation->getPaper()->getTitle(),
			"identifier" => $invitation->getPaper()->getIdentifier()
		]);
		$m->attachPaper($invitation->getPaper());
		
		return $m;
	}
}