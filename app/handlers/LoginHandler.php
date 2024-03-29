<?php
class LoginHandler extends LoggedOutHandler
{
	public function get(){
		$this->setSavedResultMessage();
		if($code = $this->getVar("eactivation")){
			$ea = EmailActivation::findByCode($code);
			if($ea && $ea->isValid()){
				$this->viewParams->username = $ea->getUser()->getEmail();
				$this->setResultMessage("Fill in your password to complete activation.");
			}
			else {
				$this->setResultMessage("Invalid activation code", "error");
			}
		}
		
		$this->showPage();
	}
	
	public function post()
	{
		if($code = $this->getVar("eactivation")){
			if(!($ea = EmailActivation::findByCode($code)))
				$this->localRedirect("login");
			else 
				$this->handleActivation($ea);
		}
		else if($this->postVar("action") == "activation" && $this->session()->allowActivation)
			$this->sendActivation();
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
				case OperationError::USER_PASSWORD_INCORRECT:
					$message = "Incorrect username or password. Please check your spelling and try again.";
					break;
				case OperationError::USER_EMAIL_NOT_ACTIVATED;
				$message = "You have not activated your account by email.";
				$this->viewParams->showActivationOption = true;
				break;
			}
			$this->viewParams->username = $username;
			$this->setResultMessage($message, "error");
			$this->showPage();
		}
	}
	
	private function sendActivation()
	{
		$user = User::findById($this->session()->activationUserId);
		$ea = EmailActivation::create($user);
		$ea->save();
		$mail = EmailActivationEmail::create($user, $ea->getCode());
		$mail->send();
		$this->setResultMessage("An activation email has been sent to your account's email address.");
		unset($this->session()->allowActivation);
		unset($this->session()->activationUserId);
		$this->showPage();
	}
	
	/**
	 * 
	 * @param EmailActivation $ea
	 */
	private function handleActivation($ea)
	{
		$password = $this->postVar("password");
		$username = $this->postVar("username");
		try {
			$ea->activate($password);
			$user = $ea->getUser();
			if($username != $user->getEmail() && $username != $user->getUsername()){
				throw new OperationException(["UsernameIncorrect"]);
			}
			$this->login($ea->getUser());
			$this->localRedirect($this->getVar("destination"));
		}
		catch(OperationException $e){
			switch($e->getErrors()[0]){
				case OperationError::EMAIL_ACTIVATION_INVALID:
					$this->setResultMessage("Invalid activation code.", "error");
					break;
				case OperationError::USER_PASSWORD_INCORRECT:
				case "UsernameIncorrect":
					$this->setResultMessage("You entered incorrect credentials.", "error");
					break;
			}
			$this->viewParams->username = $username;
			$this->showPage();
		}
	}
	
	protected function showPage()
	{
		$this->renderView("Login");
	}
	
	protected function showActivationPage($activationCode)
	{
		$ea = EmailActivation::findByCode($activationCode);
	}

}