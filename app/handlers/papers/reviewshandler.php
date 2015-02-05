<?php

class ReviewsHandler extends PaperHandler
{
	/**
	 *
	 * @var Review
	 */
	private $selectedReview;
	
	private function showPage()
	{
		$this->viewParams->selectedReview = $this->selectedReview;
		$this->viewParams->reviews = Review::findCompletedByPaper($this->paper);
		$this->viewParams->role = $this->user->getRole();
		$this->setSavedResultMessage();
		$this->renderView("papers/Reviews");
	}
	
	private function checkSelectedReview($id)
	{
		$this->selectedReview = Review::findCompletedByIdAndPaper($id, $this->paper);
		if(!$this->selectedReview){
			$this->saveResultMessage("The specified review was not found.", "error");
			$this->paperLocalRedirect("reviews");
		}
	}
	
	public function get($paper, $reviewId = null)
	{
		if($reviewId){
			$this->checkSelectedReview($reviewId);
		}
		$this->showPage();
	}
	
	private function downloadFile($file)
	{
		if($file)
			$file->sendResponse();
	}
	
	public function downloadAdminFile($paper, $reviewId)
	{
		
		$this->checkSelectedReview($reviewId);
		if($this->role->canViewReviewAdminComments($this->selectedReview)){
			$this->downloadFile($this->selectedReview->getAdminFile());
		}
	}
	
	public function downloadFileToAdmin($paper, $reviewId)
	{
	
		$this->checkSelectedReview($reviewId);
		if($this->role->canViewReviewCommentsToAdmin($this->selectedReview)){
			$this->downloadFile($this->selectedReview->getFileToAdmin());
		}
	}
	
	public function downloadFileToAuthor($paper, $reviewId)
	{
	
		$this->checkSelectedReview($reviewId);
		if($this->role->canViewReviewCommentsToAuthor($this->selectedReview)){
			$this->downloadFile($this->selectedReview->getFileToAuthor());
		}
	}
	
}