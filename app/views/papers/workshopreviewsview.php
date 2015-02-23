<?php

class WorkshopReviewsView extends PaperView
{
	public function render()
	{
		$this->setActivePaperNavLink("Workshop Reviews");
		$this->data->paperPageContent = $this->read("paper-workshop-reviews");
		$this->showBase();
	}
}