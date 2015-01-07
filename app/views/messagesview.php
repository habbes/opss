<?php

class MessagesView extends LoggedInView
{
	public function render($params)
	{
		$this->data->loadData($params->toArray());
		if($params->scope == "unread"){
			$this->data->pageTitle = "Unread Notifications";
			$this->data->pageHeading = "Unread Notifications";
		}
		else {
			$this->data->pageTitle = "All Notifications";
			$this->data->pageHeading = "All Notifications";
		}
		$this->data->pageContent = $this->read("notifications-table");
		$this->showBase($params);
	}
}