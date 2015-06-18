<?php

class ProfilePicHandler extends BaseHandler
{
	public function get($username)
	{
		$user = User::findByUsername($username);
		if($user)
			$user->sendPhotoResponse();
	}
}