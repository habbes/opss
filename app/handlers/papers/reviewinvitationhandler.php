<?php

/**
 * 
 * @author Habbes
 *
 */
class ReviewInvitationHandler extends PaperHandler
{
	
	/**
	 * 
	 * @var RegInvitation
	 */
	private $invitation;
	
	protected function getAllowedRoles()
	{
		return [UserType::ADMIN];
	}
	
	public function post()
	{
		$id = (int) $this->postVar("invitation");

		$this->invitation = RegInvitation::findValidByPaperAndId($this->paper, $id);
		if(!$this->invitation){
			$this->saveResultMessage("The specified invitation was not found or is invalid.","error");
			$this->paperLocalRedirect();
		}
		
		if(isset($_POST['cancel'])){
			$this->cancel();
		}
		else if(isset($_POST["resend"])){
			$this->resendEmail();
		}
		else {
			$this->saveResultMessage("Invalid action.", "error");
			$this->paperLocalRedirect();
		}
	}
	
	private function cancel()
	{
		$this->invitation->cancel();
		//TODO: create and send message
		//ReviewInvitationCancelledMessage::create(admin,send);
		
		$this->saveResultMessage("The invitation was cancelled successfully.", "success");
		$this->paperLocalRedirect();
		
	}
	
	private function resendEmail()
	{
		//create invitation with data from the current
		$email = $this->invitation->getEmail();
		$name = $this->invitation->getName();
		$inv = RegInvitation::create($this->user, UserType::REVIEWER, $email);
		$inv->setName($name);
		$inv->setPaper($this->paper);
		$inv->save();
		//delete current invitation
		$this->invitation->delete();
		//send email
		NewReviewerInvitationEmail::create($name, $email, $this->paper, $inv)->send();
		//notify admins
		foreach(Admin::findAll() as $admin){
			ReviewInvitationSentMessage::create($admin, $this->paper, $name, $email)->send();
		}
		
		$this->saveResultMessage("The invitation has been resent.", "success");
		$this->paperLocalRedirect();
	}
	
}