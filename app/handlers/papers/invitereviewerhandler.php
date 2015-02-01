<?php

class InviteReviewerHandler extends PaperHandler
{
	private function redirectSuccess($message)
	{
		$this->session()->resultMessage = $message;
		$this->session()->resultMessageType = "success";
		$this->paperLocalRedirect();
	}
	
	private function showPage()
	{
		$this->viewParams->reviewers = Reviewer::findAll();
		$this->renderView("papers/Home");
	}
	
	public function inviteNewReviewer()
	{
		$user = null;
		try {
			$errors = [];
			$email = $this->trimPostVar("email");
			$confirmEmail = $this->trimPostVar("confirm-email");
			$name = $this->trimPostVar("name");
			
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
					case "UserExists":
						$errors->email = sprintf("The specified email address has already been registered by %s (%s).",
						$user->getFullName(), UserType::getString($user->getType()));
				}
			}
			
			$this->viewParams->inviteReviewerErrors = $errors;
			$this->viewParams->inviteReviewerForm = new DataObject($_POST);
			$this->setResultMessage("Please correct highlighted errors.", "error");
			$this->showPage();
			
		}
	}
	
	/**
	 * 
	 * @param User $reviewer
	 */
	public function sendReviewRequest($reviewer)
	{
		try {
			$id = (int) $this->trimPostVar("reviewer");
			$reviewer = Reviewer::findById($id);
			if(!$reviewer)
				throw new OperationException(["ReviewerNotFound"]);
			$request = ReviewRequest::create($this->user, $reviewer, $this->paper);
			$request->save();
			
			//send reviewer email
			ReviewRequestEmail::create($reviewer, $request)->send();
			
			//notify reviewer
			ReviewRequestSentMessage::create($reviewer, $request)->send();
			
			//notify admins
			$message = null;
			foreach(Admin::findAll() as $admin){
				if(!$message){
					$message = ReviewRequestSentMessage::create($admin, $request);
				}
				//recycle the same message, just change the user
				$message->setUser($admin);
				$message->send();
			}
			
			$this->redirectSuccess("Request sent successfully.");
			
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case "ReviewerNotFound":
						$errors->reviewer = "The specified reviewer was not found.";
						break;
				}
			}
			$this->viewParams->reviewRequestErrors = $errors;
			$this->viewParams->reviewRequestForm = new DataObject($_POST);
			$this->setResultMessage("Please correct highlighted errors.", "error");
			$this->showPage();
		}
	}
	
}