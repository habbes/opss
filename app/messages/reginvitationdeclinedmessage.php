<?php

/**
 * message sent to admin when invitation to register has been declined
 * @author Habbes
 *
 */
class RegInvitationDeclinedMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param RegInvitation $inv
	 * @return RegInvitationDeclinedMessage
	 */
	public static function create($recipient, $inv)
	{
		$m = new static();
		$m->setUser($recipient);
		$m->setSubject("Registration Invitation Declined");
		$m->setMessageFromTemplate("reg-invitation-declined-admin",[
				"name" => $inv->getName(),
				"email" => $inv->getEmail(),
				"type" => UserType::getString($inv->getUserType())
		]);
		return $m;
	}
}