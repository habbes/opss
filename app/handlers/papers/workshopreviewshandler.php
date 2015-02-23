<?php

class WorkshopReviewsHandler extends PaperHandler
{
	
	/**
	 * 
	 * @var WorkshopReview
	 */
	private $selectedReview;
	
	private function showPage()
	{
		$this->viewParams->selectedReview = $this->selectedReview;
		$this->viewParams->reviews = WorkshopReview::findCompletedByPaper($this->paper);
		$this->viewParams->role = $this->user->getRole();
		$this->setSavedResultMessage();
		$this->renderView("papers/WorkshopReviews");
	}
	
	private function checkSelectedReview($id)
	{
		$this->selectedReview = WorkshopReview::findCompletedByIdAndPaper($id, $this->paper);
		if(!$this->selectedReview){
			$this->saveResultMessage("The specified review was not found.", "error");
			$this->paperLocalRedirect("workshop-reviews");
		}
	}
	
	public function get($paper, $reviewId = null)
	{
		if($reviewId){
			$this->checkSelectedReview($reviewId);
		}
		$this->showPage();
	}
	
	public function downloadFile($paper, $reviewId)
	{
		$this->checkSelectedReview($reviewId);
		if($file = $this->selectedReview->getFile()){
			$file->sendResponse();
		}
	}
}