<?php

/**
 * represents email sent to users after successful registration,
 * also allows the to activate their emails and account
 * @author Habbes
 *
 */
class WelcomeEmail extends Email
{
	
	protected $user;
	
	/**
	 * 
	 * @param User $user
	 * @param string $activationCode
	 * @return WelcomeEmail
	 */
	public static function create($user, $activationCode)
	{
		$e = new static();
		$e->user = $user;
		$e->setSubject("Account Activation");
		$e->setBodyFromTemplate("post-registration",
				[
					"name" => $user->getFullname(),
					"accountType" => UserType::getString($user->getType()),
					"link" => URL_ROOT."/login?eactivation=$activationCode"
				]
				);
		$e->addRecipient($user->getEmail(), $user->getFullName());
		
		return $e;
		
	}
}