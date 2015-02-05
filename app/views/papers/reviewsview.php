<?php

class ReviewsView extends PaperView
{
	public function render()
	{
		$this->setActivePaperNavLink("Reviews");
		$this->data->paperPageContent = $this->read("paper-reviews");
		$this->showBase();
	}
}