<?php

class FormView extends View
{
	public function render($params)
	{
		$this->data->form = $params->form;
		$this->show("form");
	}
}