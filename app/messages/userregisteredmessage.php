<?php

/**
 * message sent to admin when a new user registers an account
 * @author Habbes
 *
 */
class UserRegisteredMessage extends Message
{
	/**
	 * 
	 * @param User $user user who registered
	 * @return UserRegisteredMessage
	 */
	public static function create($user)
	{
		$m = new static();
		$m->setSubject("New User");
		$m->setMessageFromTemplate("user-registered",
				[
						"name" => $user->getFullName(),
						"accountType" => UserType::getString($user->getType()),
				]
		);
		$m->attachUser($user);
		return $m;
	}
}