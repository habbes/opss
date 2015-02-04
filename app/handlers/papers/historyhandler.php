<?php

class HistoryHandler extends PaperHandler
{
	public function get()
	{
		$this->viewParams->paperChanges = $this->paper->getChanges();
		
		$this->renderView("papers/History");
	}
}