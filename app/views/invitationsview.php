<?php

class InvitationsView extends LoggedInView
{
	public function render()
	{
		$this->data->pageHeading = "User Invitations";
		$this->data->pageTitle = "User Invitations";
		$this->data->pageContent = $this->read("user-invitations");
		$this->setActiveNavLink("Users","User Invitations");
		$this->showBase();
	}
}