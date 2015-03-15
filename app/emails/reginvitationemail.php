<?php

/**
 * email sent with invitation to register
 * @author Habbes
 *
 */
class RegInvitationEmail extends Email
{
	protected $user;
	
	/**
	 * 
	 * @param RegInvitation $inv
	 * @return RegInvitationEmail
	 */
	public static function create($inv)
	{
		$e = new static();
		$e->setSubject("Invitation to register");
		$e->setBodyFromTemplate("registration-invitation",
			[
				"name" => $inv->getName(),
				"email" => $inv->getEmail(),
				"accountType" => UserType::getString($inv->getUserType()),
				"acceptLink" => URL_ROOT."/registration?invitation=".$inv->getRegistrationCode(),
				"declineLink" => URL_ROOT."/invitation-declined?reg-code=".$inv->getRegistrationCode()
			]
		);
		$e->addRecipient($inv->getEmail(), $inv->getName());
		return $e;
					
	}
}