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
		else if(isset($_POST["reminder"])){
			$this->resendEmail();
		}
		else {
			$this->saveResultMessage("Invalid action.", "error");
			$this->paperLocalRedirect();
		}
	}
	
	public function cancel()
	{
		$this->invitation->cancel();
		//TODO: create and send message
		//ReviewInvitationCancelledMessage::create(admin,send);
		
		$this->saveResultMessage("The invitation was cancelled successfully.", "success");
		$this->paperLocalRedirect();
		
	}
	
	public function resendEmail()
	{
		
	}
	
}