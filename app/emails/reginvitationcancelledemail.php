<?php
/**
 * email sent to invitee when invitation is cancelled
 * @author Habbes
 *
 */
class RegInvitationCancelledEmail extends Email
{
	/**
	 * 
	 * @param string $recipient email of recipie
	 * @param RegInvitation $inv
	 * @return RegInvitationCancelledEmail
	 */
	public static function create($inv)
	{
		$e = new static();
		$e->addRecipient($inv->getEmail(), $inv->getName());
		$e->setSubject("Registration Invitation Cancelled");
		$e->setBodyFromTemplate("reg-invitation-cancelled",[
				"name" => $inv->getName(),
				"type" => UserType::getString($inv->getUserType())
		]);
		return $e;
	}
}