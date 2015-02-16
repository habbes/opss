<?php

class PapersSubmittedHandler extends UserHandler
{
	public function get()
	{
		$this->viewParams->papers = $this->viewParams->selectedUser->getPapers();
		$this->renderView("users/PapersSubmitted");
	}
}