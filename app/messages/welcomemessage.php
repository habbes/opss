<?php

class WelcomeMessage extends Message
{
	/**
	 * 
	 * @param User $user
	 * @return WelcomeMessage
	 */
	public static function create($user)
	{
		
		$m = new static();
		$m->setUser($user);
		$m->setBodyFromTemplate("welcome",
				[
					"name" => $user->getFullName(),
					"accountType" => UserType::getString($user->getType()),	
				]
			);
		return $m;
	}
		
}