<?php

class DetailsView extends PaperView
{
	public function render()
	{
		$this->showPaperNavLink("Details");
		$this->setActivePaperNavLink("Details");
		$this->data->paperPageContent = $this->read("paper-details");
		$this->showBase();
	}
}