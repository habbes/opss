<?php

class PasswordResetHandler extends LoggedOutHandler
{
	
	/**
	 * 
	 * @var PasswordRecovery
	 */
	private $recovery;
	
	private function assertRecoveryCode()
	{
		$code = $this->getVar("code");
		$recovery = PasswordRecovery::findValidByCode($code);
		if(!$recovery){
			$this->saveResultMessage("Invalid recovery code.", "error");
			$this->localRedirect();
		}
		$this->recovery = $recovery;
		
	}
	
	public function onCreate()
	{
		parent::onCreate();
		$this->assertRecoveryCode();
	}
	
	private function showPage()
	{
		$this->setSavedResultMessage();
		$this->renderView("password-recovery/PasswordReset");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		
		try {
			$username = $this->trimPostVar("username");
			$password = $this->postVar("password");
			$confirmPass = $this->postVar("confirm-password");
			$errors = [];
			$recovery = $this->recovery;
			$user = $this->recovery->getUser();
			if($username != $user->getUsername() && $username != $user->getPassword()){
				$errors[] = OperationError::USER_NOT_FOUND;
			}
			if(!User::isValidPassword($password)){
				$errors[] = OperationError::USER_PASSWORD_INVALID;
			}
			if($password != $confirmPass)
				$errors[] = OperationError::USER_PASSWORDS_DONT_MATCH;
			
			if(!empty($errors))
				throw new OperationException($errors);
			
			$this->recovery->recover($password);
			$this->login($user);
			$this->saveResultMessage("Your password has been reset successfully.", "success");
			$this->localRedirect();
		}
		catch (OperationException $e) {
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::USER_NOT_FOUND:
						$errors->username = "Incorrect username or email.";
						break;
					case OperationError::USER_PASSWORD_INVALID:
						$errors->password = "Invalid password";
						break;
					case OperationError::USER_PASSWORDS_DONT_MATCH:
						$errors->set("confirm-password", "Password do not match.");
						break;
				}
			}
			$this->setResultMessage("Please correct the highlighted changes.", "error");
			$this->viewParams->form = new DataObject($_POST);
			$this->viewParams->errors = $errors;
			$this->showPage();
			
		}
	}
}