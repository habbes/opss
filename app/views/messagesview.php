<?php

class MessagesView extends LoggedInView
{
	public function render()
	{
		if($this->data->scope == "unread"){
			$this->data->pageTitle = "Unread Notifications";
			$this->data->pageHeading = "Unread Notifications";
			$this->setActiveNavLink("Notifications", "Unread");
		}
		else {
			$this->data->pageTitle = "All Notifications";
			$this->data->pageHeading = "All Notifications";
			$this->setActiveNavLink("Notifications", "All Notifications");
		}
		$this->data->pageContent = $this->read("notifications-table");
		$this->showBase();
	}
}