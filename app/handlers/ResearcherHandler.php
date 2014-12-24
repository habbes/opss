<?php
class ResearcherHandler extends LoggedInHandler
{
	public function get()
	{
		$this->viewParams->userName = $this->user->getFullName();
		$this->show();
	}
	private function show()
	{
		$this->renderView("researcher");
	}
}