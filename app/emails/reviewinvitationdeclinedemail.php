<?php

class ReviewInvitationDeclinedEmail extends Email
{
	/**
	 * 
	 * @param User $recipient
	 * @param RegInvitation $invitation
	 */
	public static function create($recipient, $invitation)
	{
		$e = new static();
		$e->user = $recipient;
		$e->setSubject("Review Invitation Declined");
		$e->setBodyFromTemplate("review-invitation-declined", [
			"name" => $recipient->getFullName(),
			"reviewerName" => $invitation->getName(),
			"reviewerEmail" => $invitation->getEmail(),
			"title" => $invitation->getPaper()->getTitle(),
			"identifier" => $invitation->getPaper()->getIdentifier(),
			"paperLink" => $invitation->getPaper()->getAbsoluteUrl()
		]);
		
		return $e;
	}
}