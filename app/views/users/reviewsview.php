<?php

class ReviewsView extends UserView
{
	public function render()
	{
		$this->setActiveUserNavLink("All Reviews");
		$this->data->userPageContent = $this->read("user-reviews");
		$this->showBase();
	}
}