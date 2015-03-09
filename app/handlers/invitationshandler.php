<?php

class InvitationsHandler extends AdminHandler
{
	private function showPage()
	{
		$this->viewParams->userTypes = UserType::getValues();
		$this->renderView("Invitations");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		$user = null;
		try {
			$errors = [];
			$email = $this->trimPostVar("email");
			$confirmEmail = $this->trimPostVar("confirm-email");
			$name = $this->trimPostVar("name");
			$type = (int) $this->trimPostVar("type");
			
			if(!UserType::isValue($type))
				$errors[] = "UserTypeInvalid";
				
			if(!$name){
				$errors[] = "NameEmpty";
			}
			if(!User::isValidEmail($email)){
				$errors[] = "InvalidEmail";
			}
			if($email != $this->trimPostVar("confirm-email")){
				$errors[] = "EmailsDontMatch";
			}
			$user = User::findByEmail($email);
			if($user){
				$errors[] = "UserExists";
			}
				
			if(count($errors)>0){
				throw new OperationException($errors);
			}
			$inv = RegInvitation::create($this->user, $type, $email);
			$inv->setName($name);
			$inv->save();
			
			
			RegInvitationEmail::create($name, $email, $type, $inv->getRegistrationCode())->send();
			
			foreach(Admin::findAll() as $admin){
				RegInvitationSentMessage::create($admin, $inv)->send();
			}
			
			$this->setResultMessage("Invitation sent successfully.", "success");
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case "UserTypeInvalid":
						$errors->type = "Invalid selection.";
						break;
					case "NameEmpty":
						$errors->name = "Please enter name.";
						break;
					case "InvalidEmail":
						$errors->email = "The specified email is invalid.";
						break;
					case "EmailsDontMatch":
						$errors->set("confirm-email","This does not match the specified email.");
						break;
					case "UserExists":
						$errors->email = sprintf("The specified email address has already been registered by %s (%s).",
								$user->getFullName(), UserType::getString($user->getType()));
						break;
					
				}
			}
			$this->viewParams->errors = $errors;
			$this->viewParams->form = new DataObject($_POST);
			$this->setResultMessage("Please correct the highlighted errors.", "error");
		}
		
		$this->showPage();
	}
}