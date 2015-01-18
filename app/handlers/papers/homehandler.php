<?php

class HomeHandler extends PaperHandler
{
	private function showPage()
	{
		$this->renderView("papers/Home");
	}
	
	public function get()
	{
		$this->showPage();	
	}
}