<?php

class WorkshopHandler extends PaperHandler
{
	
	public function removeFromQueue()
	{
		$dest = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : $this->paper->getAbsoluteUrl();
		try {
			$this->paper->removeFromWorkshopQueue();
			$this->paper->save();
			//TODO: notification that paper removed from queue
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
}