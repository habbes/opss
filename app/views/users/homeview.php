<?php

class HomeView extends UserView
{
	public function render()
	{
		$this->setActiveUserNavLink("Details");
		$this->data->userPageContent = $this->read("user-details");
		$this->showBase();
	}
}