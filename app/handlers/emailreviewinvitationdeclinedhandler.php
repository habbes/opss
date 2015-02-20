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
		
		if(!$paper){
			//TODO should show invalid code error page
			$this->saveResultMessage("Invalid invitation code.", "error");
			$this->localRedirect("");
		}
		
		$inv->decline();
		
		foreach(Admin::findAll() as $admin){
			ReviewInvitationDeclinedMessage::create($admin, $inv)->send();
		}
		
		$admin = $inv->getAdmin();
		ReviewInvitationDeclinedEmail::create($admin, $inv)->send();
		
		$this->renderView("ReviewInvitationDeclined");
	}
}