<?php

class ReviewRequestsHandler extends ReviewerHandler
{
	
	/**
	 * 
	 * @var ReviewRequest
	 */
	private $selectedRequest;
	
	private function showPage()
	{
		$this->viewParams->selectedRequest = $this->selectedRequest;
		$this->viewParams->requests = ReviewRequest::findValidByReviewer($this->user);
		$this->setSavedResultMessage();
		$this->renderView("ReviewRequests");
	}
	
	private function checkSelectedRequest($id)
	{
		$this->selectedRequest = ReviewRequest::findValidByIdAndReviewer($id, $this->user);
		if(!$this->selectedRequest){
			$this->saveResultMessage("Request not found.", "error");
			$this->localRedirect("papers/review-requests");
		}
	}
	
	public function get($requestId = null)
	{
		if($requestId){
			$this->checkSelectedRequest($requestId);
		}
		$this->showPage();
	}
}