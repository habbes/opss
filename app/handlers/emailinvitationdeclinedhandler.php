<?php

class EmailInvitationDeclinedHandler extends BaseHandler
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
			foreach(Admin::findAll() as $a){
				ReviewInvitationDeclinedMessage::create($a, $inv)->send();
			}
			ReviewInvitationDeclinedEmail::create($admin, $inv)->send();
		}
		else {
			//generic user registration invitation
			foreach(Admin::findAll() as $a){
				RegInvitationDeclinedMessage::create($a, $inv)->send();
			}
			RegInvitationDeclinedEmail::create($admin, $inv)->send();
		}
		
		$this->renderView("InvitationDeclined");
	}
}