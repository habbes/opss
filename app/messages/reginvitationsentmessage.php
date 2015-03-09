<?php

/**
 * message sent to admin after a registration invitation has been sent to a potential user
 * @author Habbes
 *
 */
class RegInvitationSentMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param RegInvitation $invitation
	 * @return RegInvitationSentMessage
	 */
	public static function create($recipient, $invitation)
	{
		$m = new static();
		$m->setUser($recipient);
		$m->setSubject("Registration Invitation Sent");
		$m->setMessageFromTemplate("reg-invitation-sent-admin",[
			"name"=>$invitation->getName(),
			"email"=>$invitation->getEmail(),
			"type"=>UserType::getString($invitation->getUserType())
		]);
		return $m;
	}
}