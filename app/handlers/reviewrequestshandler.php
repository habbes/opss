<?php

class ReviewRequestsHandler extends ReviewerHandler
{
	private function showPage()
	{
		$this->viewParams->requests = ReviewRequest::findValidByReviewer($this->user);
		$this->renderView("ReviewRequests");
	}
	
	public function get()
	{
		$this->showPage();
	}
}