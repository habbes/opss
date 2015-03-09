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
		$this->viewParams->reviewRequests = $this->paper->getValidReviewRequests();
		$this->renderView("papers/Home");
	}
	
	public function inviteNewReviewer()
	{
		try {
			$errors = [];
			$email = $this->trimPostVar("email");
			$confirmEmail = $this->trimPostVar("confirm-email");
			$name = $this->trimPostVar("name");
			
			if($email != $this->trimPostVar("confirm-email")){
				$errors[] = "EmailsDontMatch";
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
					case OperationError::INVITATION_NAME_EMPTY:
						$errors->name = "You did not specify a name.";
						break;
					case OperationError::USER_EMAIL_INVALID:
						$errors->email = "This email does not seem to be in the correct format";
						break;
					case OperationError::USER_EMAIL_UNAVAILABLE:
						$errors->email = "The specified email address has already been registered.";
						break;
					case OperationError::INVITATION_EXISTS:
						$errors->email = "A pending invitation has already been sent to the specified address";
						break;
					
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
			
			//send reviewer email
			ReviewRequestEmail::create($reviewer, $request)->send();
			$this->redirectSuccess("Request sent successfully.");
			
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::REVIEW_REQUEST_DUPLICATE_PENDING:
						$errors->reviewer = "The specified reviewer already has a pending request for this paper.";
						break;
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