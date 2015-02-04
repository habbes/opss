<?php

class ReviewHandler extends PaperHandler
{
	
	protected function getAllowedRoles()
	{
		return [UserType::REVIEWER];
	}
	
	private function showPage()
	{
		$this->renderView("papers/Home");
	}
	
	private function redirectSuccess()
	{
		$this->saveResultMessage("Review submitted successfully.", "success");
		$this->localRedirect();
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		try {
			$errors = [];
			$review = $this->paper->getCurrentReview();
			if(!$review)
				throw new OperationException(["ReviewNotFound"]);
			$recommendation = $this->trimPostVar("recommendation");
			if(!Review::isValidVerdict($recommendation))
				$errors[] = OperationError::REVIEW_VERDICT_INVALID;
			
			$fileToAdmin = $this->fileVar("file");
			$commentsToAdmin = $this->trimPostVar("comments");
			if(!$commentsToAdmin && !$fileToAdmin->tmp_name)
				$errors[] = OperationError::REVIEW_COMMENTS_TO_ADMIN_EMPTY;
			
			$fileToAuthor = $this->fileVar("author-file");
			$commentsToAuthor = $this->trimPostVar("author-comments");
			if(!$fileToAuthor->tmp_name && ! $commentsToAuthor)
				$errors[] = OperationError::REVIEW_COMMENTS_TO_RESEARCHER_EMPTY;
			
			if(!empty($errors))
				throw new OperationException($errors);
			
			
			if($commentsToAdmin)
				$review->setCommentsToAdmin($commentsToAdmin);
			
			if($fileToAdmin->tmp_name)
				$review->setFileToAdmin($fileToAdmin->name, $fileToAdmin->tmp_name);
			
			if($commentsToAuthor)
				$review->setCommentsToAuthor($commentsToAuthor);
			
			if($fileToAuthor->tmp_name)
				$review->setFileToAuthor($fileToAuthor->name, $fileToAuthor->tmp_name);
		
			$review->save();
			$this->paper->submitReview($this->postVar("recommendation"));
			$this->redirectSuccess();
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case "ReviewNotFound":
						$this->saveResultMessage("Review not found.", "error");
						$this->localRedirect();
						break;
					case OperationError::REVIEW_VERDICT_INVALID:
						$errors->recommendation = "Invalid option";
						break;
					case OperationError::REVIEW_COMMENTS_TO_ADMIN_EMPTY:
						$errors->comments = "Enter comments or upload file.";
						break;
					case OperationError::REVIEW_COMMENTS_TO_RESEARCHER_EMPTY:
						$errors->set("author-comments", "Enter comments for researcher or upload file.");
						break;
						
				}
			}
			$this->viewParams->reviewErrors = $errors;
			$this->viewParams->reviewForm = new DataObject($_POST);
			$this->setResultMessage("Please correct the highlighted errors.", "error");
			$this->showPage();
		}
	}
}