<?php

class ReviewRequestHandler extends PaperHandler
{
	
	/**
	 * 
	 * @var ReviewRequest
	 */
	private $request;
	
	protected function getAllowedRoles()
	{
		return [UserType::ADMIN];
	}
	
	public function post()
	{
		$this->request = $this->paper->getValidReviewRequestById((int) $this->postVar("request"));
		if(!$this->request){
			$this->saveResultMessage("The specified review request was not found or is no longer valid.", "error");
			$this->paperLocalRedirect();
		}
		
		if(isset($_POST["cancel"])){
			$this->cancel();
		}
		else if(isset($_POST["reminder"])){
			$this->sendReminder();
		}
		else{
			$this->saveResultMessage("Invalid action.", "error");
			$this->paperLocalRedirect();
		
		}
	}
	
	private function cancel()
	{
		$this->request->cancel();
		$this->request->save();
		$this->saveResultMessage("The review request was cancelled successfully.", "success");
		$this->paperLocalRedirect();
	}
	
	private function sendReminder($request)
	{
		$reviewer = $this->request->getReviewer();
	}
}