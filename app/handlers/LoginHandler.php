<?php
class LoginHandler extends LoggedOutHandler
{
	public function get(){
		$this->showPage();
	}
	
	public function post()
	{
		$username = $this->postVar("username");
		$password = $this->postVar("password");
		
		try {
			$user = User::login($username, $password);
			$this->login($user);
			$this->localRedirect($this->getVar("destination"));
		
		}
		catch(OperationException $e) {
			switch($e->getErrors()[0]){
				case OperationError::USER_NOT_FOUND:
					$message = "Username or email not found.";
					break;
				case OperationError::USER_PASSWORD_INCORRECT:
					$message = "Password Incorrect";
					break;
			}
			$this->viewParams->username = $username;
			$this->viewParams->formResult = $message;
			$this->showPage();
		}
		
	}
	
	protected function showPage()
	{
		$this->renderView("Login");
	}

}