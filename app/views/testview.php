<?php

class TestView extends View
{
	public function render($params)
	{
		$this->data->files = $params->files;
		$this->show("test");
	}
}