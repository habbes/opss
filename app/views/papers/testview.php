<?php

class TestView extends PaperView
{
	public function render()
	{
		$this->data->paperPageContent = "This is another test";
		$this->showPaperNavLink("Details");
		$this->showBase();
	}
}