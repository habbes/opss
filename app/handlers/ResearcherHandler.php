<?php
class ResearcherHandler extends RequestHandler
{
	public function get()
	{
		$this->viewParams->userName = Login::getUser()->getFullName();
		$this->show();
	}
	private function show()
	{
		$this->renderView("researcher");
	}
}