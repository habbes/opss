<?php

class HistoryView extends PaperView
{
	public function render()
	{
		$this->setActivePaperNavLink("History");
		$this->data->paperPageContent = $this->read("paper-history");
		$this->showBase();
	}
}