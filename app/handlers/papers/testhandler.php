<?php

class TestHandler extends PaperHandler
{
	public function get($identifier)
	{
		echo $this->paper->getTitle();
	}
}