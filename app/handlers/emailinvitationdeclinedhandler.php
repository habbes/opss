<?php

class EmailReviewInvitationDeclinedHandler extends BaseHandler
{
	public function get()
	{
		$inv = RegInvitation::findValidByCode($this->getVar("reg-code"));
		if(!$inv){
			$this->saveResultMessage("Invalid invitation code.", "error");
			$this->localRedirect("");
		}
		
		$paper = $inv->getPaper();
		$admin = $inv->getAdmin();
		$inv->decline();
		
		if($paper){
			//the invitation was for a reviewer to review a paper
			foreach(Admin::findAll() as $admin){
				ReviewInvitationDeclinedMessage::create($admin, $inv)->send();
			}
			ReviewInvitationDeclinedEmail::create($admin, $inv)->send();
		}
		else {
			//generic user registration invitation
			foreach(Admin::findAll() as $admin){
				RegInvitationDeclinedMessage::create($admin, $inv)->send();
			}
			RegInvitationDeclinedEmail::create($admin, $inv)->send();
		}
		
		$this->renderView("InvitationDeclined");
	}
}