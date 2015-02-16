<?php

class WorkshopHandler extends PaperHandler
{
	
	public function removeFromQueue()
	{
		$dest = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : $this->paper->getAbsoluteUrl();
		try {
			$this->paper->removeFromWorkshopQueue();
			$this->paper->save();
			//TODO notification that paper removed from queue
			$this->saveResultMessage("Paper successfully removed from workshop review queue.", "success");
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::PAPER_NOT_IN_WORKSHOP:
						$this->saveResultMessage("The paper has not been added to any workshop review queue.", "error");
						break;
					
				}
			}
		}
		
		$this->redirect($dest);
		
	}
	
	public function post()
	{
		try {
			//check errors
			$verdict = $this->trimPostVar("verdict");
			$comments = $this->trimPostVar("comments");
			$file = $this->fileVar("file");
			
			$wreview = WorkshopReview::create($this->paper, $this->paper->getWorkshop(), $this->user);
			$wreview->setComments($comments);
			if($file->tmp_name)
				$wreview->setFile($file->name, $file->tmp_name);
			$wreview->save();
			$wreview = $this->paper->submitWorkshopReview($verdict);
			$this->saveResultMessage("Review submitted successfully.", "success");
			$this->paperLocalRedirect();
		}
		catch(OperationException $e){
			
		}
	}
}