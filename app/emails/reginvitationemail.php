<?php

/**
 * email sent with invitation to register
 * @author Habbes
 *
 */
class RegInvitationEmail extends Email
{
	protected $user;
	
	public static function create($name, $email, $accountType, $regCode)
	{
		$e = new static();
		$e->setSubject("Invitation to register");
		$e->setBodyFromTemplate("registration-invitation",
			[
				"name" => $name,
				"email" => $email,
				"accountType" => $accountType,
				"link" => URL_REGISTRATION."/invitation=$regCode"
			]
		);
		$e->addRecipient($email, $name);
		return $e;
					
	}
}