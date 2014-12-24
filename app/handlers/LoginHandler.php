<?php
class LoginHandler extends LoggedOutHandler
{
	public function get(){}
	public function post()
	{
		$username = $this->postVar("username");
		$password = $this->postVar("password");
		
		if($user = User::login($username, $password)){
			
		}
	}
	public function redirect($handler){
		header("Location:");
	}
}