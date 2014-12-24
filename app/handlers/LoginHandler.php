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
			$this->localRedirect("researcher");
			exit;
		}else{
			echo "Unsuccessful login <a href='".URL_ROOT."/login'>Try Again</a>";
			exit;
		}
	}
	protected function show()
	{
		$this->renderView("form");
	}

}