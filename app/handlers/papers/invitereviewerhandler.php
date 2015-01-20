<?php

class InviteReviewerHandler extends PaperHandler
{
	private function redirectSuccess($message)
	{
		$this->session()->resultMessage = $message;
		$this->session()->resultMessageType = "success";
		$this->paperLocalRedirect();
	}
	
	public function post()
	{
		try {
			$email = $this->trimPostVar("email");
			$confirmEmail = $this->trimPostVar("confirm-email");
			$name = $this->trimPostVar("name");
			if($email != $this->trimPostVar("confirm-email")){
				throw new OperationException(["EmailsDontMatch"]);
			}
			
			$user = User::findByEmail($email);
			if($user){
				$this->inviteExistingReviewer($user);
			}
			else {
				$this->inviteNewReviewer($name, $email);
			}
		}
		catch (OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case "EmailsDontMatch":
						$errors->set("confirm-email", "This does not match the specified email.");
						break;
					case "NameEmpty":
						$errors->name = "You did not specify a name.";
						break;
					case "InvalidEmail":
						$errors->email = "This email does not seem to be in the correct format";
						break;
				}
			}
			
			$this->viewParams->inviteReviewerErrors = $errors;
			$this->viewParams->inviteReviewerForm = new DataObject($_POST);
			$this->setResultMessage("Please correct highlighted errors.", "error");
			$this->renderView("papers/Home");
			
		}
	}
	
	/**
	 * 
	 * @param User $reviewer
	 */
	private function inviteExisitingReviewer($reviewer)
	{
		
	}
	
	public function inviteNewReviewer($name, $email)
	{
		$errors = [];
		if(!$name){
			$errors[] = "NameEmpty";
		}
		if(!User::isValidEmail($email)){
			$errors[] = "InvalidEmail";
		}
		if(count($errors)>0){
			throw new OperationException($errors);
		}
		$inv = RegInvitation::create($this->user, UserType::REVIEWER, $email);
		$inv->setName($name);
		$inv->setPaper($this->paper);
		$inv->save();
		NewReviewerInvitationEmail::create($name, $email, $this->paper, $inv)->send();
		foreach(Admin::findAll() as $admin){
			ReviewInvitationSentMessage::create($admin, $this->paper, $name, $email)->send();
		}
		$this->redirectSuccess("Invitation sent successfully.");
	}
}