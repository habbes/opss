<?php

class ReviewsHandler extends UserHandler
{
	public function get()
	{
		$this->viewParams->reviews = $this->viewParams->selectedUser->getReviews();
		$this->renderView("users/Reviews");
	}
}