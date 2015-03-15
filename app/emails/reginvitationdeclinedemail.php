<?php

/**
 * email sent to admin when registration invitation has been declined
 * @author Habbes
 *
 */
class RegInvitationDeclinedEmail extends Email
{
	/**
	 * 
	 * @param Recipient $recipient
	 * @param RegInvitation $inv
	 * @return RegInvitationDeclinedEmail
	 */
	public static function create($recipient, $inv)
	{
		$e = new static();
		$e->setSubject("Registration Invitation Declined");
		$e->addUser($recipient);
		$e->setBodyFromTemplate("reg-invitation-declined",[
				"name" => $recipient->getFullName(),
				"invName" => $inv->getName(),
				"invEmail" => $inv->getEmail(),
				"invType" => UserType::getString($inv->getUserType())
		]);
		return $e;
	}
}