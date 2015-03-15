<?php

class InvitationDeclinedView extends BaseView
{
	public function render()
	{
		$this->data->pageTitle = "Invitation Decline Response";
		$this->data->pageContent = $this->read("review-invitation-declined-message");
		$this->showBase();
	}
}