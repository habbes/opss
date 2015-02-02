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
			$this->saveResultMessage("The specified request was not found or is no longer valid.", "error");
			$this->localRedirect("papers/review-requests");
		}
	}
	
	private function accept()
	{
		
	}
	
	private function decline()
	{
		
	}
	
	public function get($requestId = null)
	{
		if($requestId){
			$this->checkSelectedRequest($requestId);
		}
		$this->showPage();
	}
	
	public function post($requestId)
	{
		$this->checkSelectedRequest($requestId);
		try {
			$comments = $this->trimPostVar("comments");
			$this->selectedRequest->setResponseText($comments);
			if(isset($_POST['accept'])){
				$this->selectedRequest->accept();
				$this->selectedRequest->save();
				
				//send paper for review
				$paper = $this->selectedRequest->getPaper();
				$paper->sendForReview($this->user, $this->selectedRequest->getAdmin());
				//notify reviewer
				PaperSentForReviewMessage::create($this->user, $paper, $this->user)->send();
				//notify researcher
				PaperSentForReviewMessage::create($paper->getResearcher(), $paper, $this->user)->send();
				//notify admins
				$msg = null;
				foreach(Admin::findAll() as $admin){
					if(!$msg){
						$msg = PaperSentForReviewMessage::create($admin, $paper, $this->user);
					}
					else {
						$msg->setUser($admin);
					}
					$msg->send();
				}
				$this->saveResultMessage("Review request accepted. You may start reviewing the paper.", "success");
				$this->localRedirect("papers/".$this->selectedRequest->getPaper()->getIdentifier());
			}
			else if(isset($_POST['decline'])){
				$this->selectedRequest->reject();
				$this->selectedRequest->save();
				$this->saveResultMessage("Review request declined successfully.", "success");
				$this->localRedirect("papers/review-requests");
			}
			else {
				throw new OperationException(["InvalidAction"]);
			}
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case "InvalidAction":
						$errors->action = "Invalid action.";
						break;
					case OperationError::REVIEW_REQUEST_INVALID:
						$this->checkSelectedRequest();
						break;
				}
			}
			$this->viewParams->form = new DataObject($_POST);
			$this->viewParams->errors = $errors;
			$this->showPage();
		}
		
	}
}