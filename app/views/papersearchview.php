<?php

class PaperSearcAjaxView extends View
{
	public function render()
	{
		$response = new JsonObject();
		$response->recordsTable =$this->read("papers-table");
		$response->sendResponse();
	}
	
}