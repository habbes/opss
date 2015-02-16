<?php

class ReviewSubmittedHandler extends PaperHandler
{
	
	private $review;
	
	private function getReview()
	{
		if(!$this->review)
			$this->review = $this->paper->getRecentlySubmittedReview();
		return $this->review;
	}
	
	private function showPage()
	{
		$this->viewParams->reviewer = $this->getReview()->getReviewer();
		$this->viewParams->review = $this->getReview();
		$this->renderView("papers/Home");
	}
	
	public function downloadFileToAdmin()
	{
		$review = $this->getReview();
		if($review && $review->hasFileToAdmin())
			return $review->getFileToAdmin()->sendResponse();
	}
	
	public function downloadFileToAuthor()
	{
		$review = $this->getReview();
		if($review && $review->hasFileToAuthor())
			return $review->getFileToAuthor()->sendResponse();
	}
	
	public function post()
	{
		$form = new DataObject($_POST);
		try {
			$errors = [];
			$verdict = $this->trimPostVar("verdict");
			if(!Review::isValidAdminVerdict($verdict))
				$errors[] = OperationError::REVIEW_VERDICT_INVALID;
			
			$review = $this->getReview();
			if(!$review)
				$errors[] = "ReviewNotFound";
			$postComments = $this->postVar("post-comments");
			if(!$postComments)
				$form->set("post-comments", false);
			
			if(!empty($errors))
				throw new OperationException($errors);
			
			if($postComments){
				$review->setPosted(true);
			}
			
			$file = $this->fileVar("file");
			if($file->tmp_name)
				$review->setAdminFile($file->name, $file->tmp_name);
			
			$review->setAdminComments($this->trimPostVar("comments"));
			
			$review->save();
			$review = $this->paper->submitAdminReview($verdict);
			
			//notify researcher
			ReviewForwardedMessage::create($this->paper->getResearcher(), $review)->send();
			//notify admins
			$msg = null;
			foreach(Admin::findAll() as $admin){
				if(!$msg)
					$msg = ReviewForwardedMessage::create($admin, $review);
				else
					$msg->setUser($admin);
				$msg->send();
			}
			
			
			//email researcher
			ReviewSubmittedResearcherEmail::create($this->paper->getResearcher(), $review);
			
			$this->saveResultMessage("Review forwarded successfully.", "success");
			$this->paperLocalRedirect();
			
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case "ReviewNotFound":
						$this->saveResultMessage("Review not found.", "error");
						$this->paperLocalRedirect();
						break;
					case OperationError::REVIEW_VERDICT_INVALID:
						$errors->verdict = "Invalid option.";
						break;					
				}
				
			}
			$this->viewParams->reviewSubmittedForm = $form;
			$this->viewParams->reviewSubmittedErrors = $errors;
			$this->setResultMessage("Please correct the highlighted errors.", "error");
			$this->showPage();
		}
	}
}