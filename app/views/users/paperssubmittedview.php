<?php

class PapersSubmittedView extends UserView
{
	public function render()
	{
		$this->setActiveUserNavLink("Papers Submitted");
		$this->data->userPageContent = $this->read("user-papers-submitted");
		$this->showBase();
	}
}