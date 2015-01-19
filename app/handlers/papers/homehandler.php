<?php

class HomeHandler extends PaperHandler
{
	private function showPage()
	{
		$this->renderView("papers/Home");
	}
	
	public function get()
	{
		$this->showPage();	
	}
	
	public function handleVetReview()
	{
		$this->viewParams->form = new DataObject($_POST);
		try {
			$vet = VetReview::create($this->paper);
			$vet->setComments($this->trimPostVar("comments"));
			$verdict = "";
			
			if(isset($_POST[VetReview::VERDICT_REJECTED])){
				$verdict = VetReview::VERDICT_REJECTED;
			}
			else if(isset($_POST[VetReview::VERDICT_ACCEPTED]))
				$verdict = VetReview::VERDICT_ACCEPTED;
			
			$vet->submit($this->user, $verdict);
		}
		catch(OperationException $e)
		{
			$this->viewParams->errors = new DataObject();
			$this->setResultMessage("Please correct the highlighted errors.", "error");
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::VET_INVALID_VERDICT:
						$this->viewParams->errors->verdict = "Invalid verdict selected.";
						echo "ERROR $error<br>";
						break;
					case OperationError::VET_COMMENTS_EMPTY:
						$this->viewParams->errors->comments = "Please enter comments.";
						echo "ERROR $error<br>";
						break;
					default:
						echo "ERROR $error<br>";
				}
			}
			
		}
		
		$this->showPage();
	}
}