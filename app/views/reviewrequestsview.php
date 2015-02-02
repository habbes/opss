<?php

class ReviewRequestsView extends LoggedInView
{
	public function render()
	{
		$this->setActiveNavLink("Papers", "Pending Requests");
		$this->data->pageHeading = "Pending Requests";
		$this->data->pageTitle = "Pending Requests";
		$this->data->pageContent = $this->read("review-requests-reviewer");
		$this->showBase();
	}
}