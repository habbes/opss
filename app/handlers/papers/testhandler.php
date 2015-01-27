<?php

class TestHandler extends PaperHandler
{
	public function get($identifier)
	{
		$this->renderView("papers/Test");
	}
}