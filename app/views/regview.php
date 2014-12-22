<?php

class RegView extends View
{
	public function render($params)
	{
		$this->data->resultMessage = $params->resultMessage;
		$this->show("regtest");
	}
}