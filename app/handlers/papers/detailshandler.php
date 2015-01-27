<?php

class DetailsHandler extends PaperHandler
{
	public function get()
	{
		$this->renderView("papers/Details");
	}
}