<?php

class AdminSetupHandler extends LoggedOutHandler
{
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		$this->handleRegistration();
	}
	
	private function showPage()
	{
		$this->viewParams->titles = SysDataList::get("titles-en");
		$this->renderView("AdminSetup");
	}
	
	private function handleRegistration()
	{
		$this->viewParams->form = new DataObject($_POST);
		try {
			$errors = [];
			$user = User::create(UserType::ADMIN);
			$user->setTitle($this->trimPostVar("title"));
			$user->setFirstName($this->trimPostVar("firstname"));
			$user->setLastName($this->trimPostVar("lastname"));
			$user->setUsername($this->trimPostVar("username"));
			$user->setEmail($this->trimPostVar("email"));
			$pass = $this->postVar("password");
			$passConfirm = $this->postVar("password-confirm");
			if($pass != $passConfirm)
				$erros[] = OperationError::USER_PASSWORDS_DONT_MATCH;
			
			$user->setPassword($this->postVar("password"));
			$user->save();
			
			$this->login($user);
			$this->localRedirect("");
		}
		catch(OperationException$e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::USER_FIRST_NAME_EMPTY:
						$errors->firstname = "First name is required";
						break;
					case OperationError::USER_LAST_NAME_EMPTY:
						$errors->lastname = "Last name is required";
						break;
					case OperationError::USER_USERNAME_INVALID:
						$errors->username = "Invalid username. Please user only letters, numbers, _ and -";
						break;
					case OperationError::USER_USERNAME_UNAVAILABLE:
						$errors->username = "This username is not available, please choose a different one.";
						break;
					case OperationError::USER_EMAIL_INVALID:
						$errors->email = "Invalid email address. An email address should be of the form johndoe@example.com";
						break;
					case OperationError::USER_EMAIL_UNAVAILABLE:
						$errors->email = "This email is not available, please choose a different one.";
						break;
					case OperationError::USER_PASSWORD_INVALID:
						$errors->password = "Invalid password. The password should have 6 to 50 characters including "
								."letters, numbers, and special characters like *, !, etc.";
								break;
					case OperationError::USER_PASSWORDS_DONT_MATCH:
						$errors->set("password-confirm", "This does not match the entered password");
						break;
				}
			}
			$this->viewParams->errors = $errors;
		}
		catch(Exception $e) {
			echo "Errors: ".$e->getMessage()."<br>";
		}
		
		$this->showPage();
		
	}
}