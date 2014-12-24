<?php
class ResearcherHandler extends RequestHandler
{
	public function get()
	{
		$this->show();
	}
	private function show()
	{
		$this->renderView("researcher");
	}
}