<?php

/**
 * email sent to with link to email activation code
 * @author Habbes
 *
 */
class EmailActivationEmail extends Email
{
	protected $user;
	
	/**
	 *
	 * @param User $user
	 * @param string $activationCode
	 * @return EmailActivationEmail
	 */
	public static function create($user, $activationCode)
	{
		$e = new static();
		$e->user = $user;
		$e->setSubject("Account Activation");
		$e->setBodyFromTemplate("email-activation",
				[
						"name" => $user->getFullname(),
						"link" => URL_ROOT."/login?eactivation=$activationCode"
				]
		);
		$e->addRecipient($user->getEmail(), $user->getFullName());
	
		return $e;
	
	}
}