<?php

class InvitationsHandler extends AdminHandler
{
	
	/**
	 * 
	 * @var RegInvitation
	 */
	private $invitation;
	
	private function redirectInvitations()
	{
		$this->localRedirect("invitations");
	}
	
	private function showPage()
	{
		$this->viewParams->userTypes = UserType::getValues();
		$this->viewParams->invitations = RegInvitation::findValid();
		$this->setSavedResultMessage();
		$this->renderView("Invitations");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		try {
			$errors = [];
			$email = $this->trimPostVar("email");
			$confirmEmail = $this->trimPostVar("confirm-email");
			$name = $this->trimPostVar("name");
			$type = (int) $this->trimPostVar("type");
						if($email != $this->trimPostVar("confirm-email")){
				$errors[] = "EmailsDontMatch";
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
					case OperationError::USER_TYPE_INVALID:
						$errors->type = "Invalid selection.";
						break;
					case OperationError::INVITATION_NAME_EMPTY:
						$errors->name = "Please enter name.";
						break;
					case OperationError::USER_EMAIL_INVALID:
						$errors->email = "The specified email is invalid.";
						break;
					case "EmailsDontMatch":
						$errors->set("confirm-email","This does not match the specified email.");
						break;
					case OperationError::USER_EMAIL_UNAVAILABLE:
						$errors->email = "The specified email address has already been registered.";
						break;
					case OperationError::INVITATION_EXISTS:
						$errors->email = "A pending invitation has already been sent to the specified address.";
						break;
					
				}
			}
			$this->viewParams->errors = $errors;
			$this->viewParams->form = new DataObject($_POST);
			$this->setResultMessage("Please correct the highlighted errors.", "error");
		}
		
		$this->showPage();
	}
	
	public function manageInvitation()
	{
		$id = (int) $this->postVar("invitation");
		$invitation = RegInvitation::findValidById($id);
		if($invitation = RegInvitation::findValidById($id)){
			$this->invitation = $invitation;
			if(isset($_POST['cancel'])){
				$this->cancel();
			}
			else if(isset($_POST['resend'])){
				$this->resendEmail();
			}
			else {
				$this->saveResultMessage("Invalid Action.", "error");
				$this->redirectInvitations();
			}
		}
	}
	
	private function resendEmail()
	{
		//create invitation with data from the current
		$email = $this->invitation->getEmail();
		$name = $this->invitation->getName();
		$type = $this->invitation->getUserType();
		$inv = RegInvitation::create($this->user, $type, $email);
		$inv->setName($name);
		//delete current invitation
		$this->invitation->delete();
		$inv->save();
		
		
		//notify admins
		foreach(Admin::findAll() as $admin){
			RegInvitationSentMessage::create($admin, $inv)->send();
		}
		//send email
		RegInvitationEmail::create($name, $email, $type,$inv->getRegistrationCode());
		$this->saveResultMessage("The invitation has been resent.", "success");
		$this->redirectInvitations();
	}
	
	private function cancel()
	{
		$this->invitation->cancel();
		$name = $this->invitation->getName();
		$email = $this->invitation->getEmail();
		
		//TODO: send messages
		//notify admins
		/*
		foreach(Admin::findAll() as $admin){
			ReviewInvitationCancelledMessage::create($admin, $this->paper, $name, $email)->send();
		}
		//send email to invitee
		NewReviewerInvitationCancelledEmail::create($name, $email, $this->paper)->send();
		*/
		$this->saveResultMessage("The invitation was cancelled successfully.", "success");
		$this->redirectInvitations();
	}
	
}