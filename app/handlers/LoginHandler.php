<?php
class LoginHandler extends LoggedOutHandler
{
	public function get(){
		$this->show();
	}
	public function post()
	{
		$username = $this->postVar("username");
		$password = $this->postVar("password");
		
		if($user = User::login($username, $password))
		{
			echo $user->getFullName()." has logged in";
		}
	}
	protected function show()
	{
		$this->renderView("form");
	}
}