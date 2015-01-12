<?php
class LoginHandler extends LoggedOutHandler
{
	public function redirect($handler){
		header("Location:");
	}
	public function get(){
		if($code = $this->getVar("eactivation")){
			$ea = EmailActivation::findByCode($code);
			if($ea && $ea->isValid()){
				$this->viewParams->username = $ea->getUser()->getEmail();
				$this->viewParams->formResult = "Fill in your password to complete activation.";
			}
			else {
				$this->viewParams->formResult = "Invalid activation code";
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
	
	private function sendActivation()
	{
		$user = User::findById($this->session()->activationUserId);
		$ea = EmailActivation::create($user);
		$ea->save();
		$mail = EmailActivationEmail::create($user, $ea->getCode());
		$mail->send();
		$this->viewParams->formResult = "An activation email has been sent to your account's email address.";
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
					$this->viewParams->formResult = "Invalid activation code.";
					break;
				case OperationError::USER_PASSWORD_INCORRECT:
				case "UsernameIncorrect":
					$this->viewParams->formResult = "You entered incorrect credentials.";
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