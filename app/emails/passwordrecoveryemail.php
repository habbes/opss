<?php

/**
 * 
 * @author Habbes
 *
 */
class PasswordRecoveryEmail extends Email
{
	
	/**
	 * 
	 * @param User $user
	 * @param string $recoveryCode
	 */
	public static function create($user, $recoveryCode)
	{
		$e = new static();
		$e->addUser($user);
		$e->setSubject("Password Recovery");
		$e->setBodyFromTemplate("password-recovery",[
				"name" => $user->getFullName(),
				"link" => URL_ROOT ."/password-reset?code=$recoveryCode",
		]);
		
		return $e;
	}
}