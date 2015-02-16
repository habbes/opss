<?php

class PapersReviewingView extends UserView
{
	public function render()
	{
		$this->setActiveUserNavLink("Papers Reviewing");
		$this->data->userPageContent = $this->read("user-papers-reviewing");
		$this->showBase();
	}
}