<?php

/**
 * base view that has a method to display the main layout
 * @author Habbes
 *
 */
class BaseView extends View
{
	/**
	 * display the page on top of the main layout
	 */
	public function showBase()
	{
		if($this->data->pageNav)
			$this->data->pageBody = $this->read("main-layout");
		else 
			$this->data->pageBody = $this->data->pageContent;
		$this->show("base");
	}
}