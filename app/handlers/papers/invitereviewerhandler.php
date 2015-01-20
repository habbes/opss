<?php

class InviteReviewerHandler extends PaperHandler
{
	public function post()
	{
		try {
			$email = $this->trimPostVar("email");
			$confirmEmail = $this->trimPostVar("confirm-email");
			$name = $this->trimPostVar("name");
			if($email != $this->trimPostVar("confirm-email")){
				throw new OperationError(["EmailsDontMatch"]);
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
				}
			}
			
			$this->viewParams->inviteReviewerErrors = $errors;
			$this->viewParams->inviteReviewerForm = new DataObject($_POST);
			
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
		$inv = RegInvitation::create($this->user, UserType::REVIEWER, $email);
		$inv->save();
	}
}