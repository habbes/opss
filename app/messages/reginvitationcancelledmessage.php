<?php

/**
 * message sent to admin after a registration invitation is cancelled
 * @author Habbes
 *
 */
class RegInvitationCancelledMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param RegInvitation $inv
	 * @return RegInvitationCancelledMessage
	 */
	public static function create($recipient, $inv)
	{
		$m = new static();
		$m->setUser($recipient);
		$m->setSubject("Registration Invitation Cancelled");		
		$m->setMessageFromTemplate("reg-invitation-cancelled-admin", [
			"name" => $inv->getName(),
			"email" => $inv->getEmail(),
			"type" => UserType::getString($inv->getUserType())	
		]);
		return $m;
	}
}