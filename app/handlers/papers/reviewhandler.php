<?php

class ReviewHandler extends PaperHandler
{
	private function showPage()
	{
		$this->renderView("papers/Home");
	}
	
	private function redirectSuccess()
	{
		$this->session()->resultMessage = "Review submitted successfully";
		$this->session()->resultMessageType = "success";
		$this->paperLocalRedirect();
	}
	
	public function post()
	{
		try {
			$review = $this->paper->getCurrentReview();
			$review->setComments($this->trimPostVar("comments"));
			$review->setResearcherComments($this->trimPostVar("researcher-comments"));
			$review->save();
			$this->paper->submitReview($this->postVar("recommendation"));
			$this->redirectSuccess();
		}
		catch(OperationException $e){
			$this->setResultMessage("Errors occured.", "error");
			$this->showPage();
		}
	}
}