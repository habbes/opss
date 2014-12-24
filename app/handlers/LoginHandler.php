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
			Login::userLogin($user);
			$this->redirect("researcher");
		}
	}
	protected function show()
	{
		$this->renderView("form");
	}
	protected function redirect($handler)
	{
		header("Location:" . $handler );
	}
}