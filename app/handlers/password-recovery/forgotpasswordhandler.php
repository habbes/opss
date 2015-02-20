<?php

class ForgotPasswordHandler extends LoggedOutHandler
{
	private function showPage()
	{
		$this->renderView("password-recovery/ForgotPassword");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		$this->viewParams->form = new DataObject($_POST);
		try {
			$username = $this->trimPostVar("username");
			$user = User::findByUsernameOrEmail($username);
			if(!$user)
				throw new OperationException([OperationError::NOT_FOUND]);
			
			$recovery = PasswordRecovery::create($user);
			$recovery->save();
			PasswordRecoveryEmail::create($user, $recovery->getCode())->send();
			
			$this->setResultMessage("A recovery email has been sent to your account's email address.", "success");
			$this->showPage();
		
		}
		catch(OperationException $e)
		{
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::NOT_FOUND:
						$this->setResultMessage("Incorrect username or email.", "error");
						break;
				}
			}
			
			$this->showPage();
		}
	}
}