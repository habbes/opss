<?php

class PapersReviewingHandler extends UserHandler
{
	public function get()
	{
		$this->viewParams->reviews = $this->viewParams->selectedUser->getCurrentReviews();
		$this->renderView("users/PapersReviewing");
	}
}