<?php

class HomeView extends PaperView
{
	public function render()
	{
		
		$this->setActivePaperNavLink("Home");
		$this->pageContent = $this->read("paper-home");
		$this->showBase();
	}
}