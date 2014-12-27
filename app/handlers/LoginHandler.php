<?php
class LoginHandler extends LoggedOutHandler
{
	public function get(){
		$this->showPage();
	}
	
	public function post()
	{
		if($this->postVar("action") == "activation" && $this->session()->allowActivation)
			$this->handleActivation();
		else
			$this->handleLogin();
		
	}
	
	private function handleLogin()
	{
		$username = $this->postVar("username");
		$password = $this->postVar("password");
	
		try {
			$user = User::login($username, $password);
			if(!$user->isEmailActivated()){
				$this->session()->allowActivation = true;
				$this->session()->activationUserId = $user->getId();
				throw new OperationException([OperationError::USER_EMAIL_NOT_ACTIVATED]);
			}
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
				case OperationError::USER_EMAIL_NOT_ACTIVATED;
				$message = "You have not activated your account by email.";
				$this->viewParams->showActivationOption = true;
				break;
			}
			$this->viewParams->username = $username;
			$this->viewParams->formResult = $message;
			$this->showPage();
		}
	}
	
	private function handleActivation()
	{
		$user = User::findById($this->session()->activationUserId);
		$ea = EmailActivation::create($user);
		$mail = EmailActivationEmail::create($user, $ea->getCode());
		$mail->send();
		$this->viewParams->formResult = "An activation email has been sent to your account's email address.";
		unset($this->session()->allowActivation);
		unset($this->session()->activationUserId);
		$this->showPage();
	}
	
	protected function showPage()
	{
		$this->renderView("Login");
	}

}