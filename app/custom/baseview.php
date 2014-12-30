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
		$this->data->pageBody = $this->read("main-layout");		
		$this->show("base");
	}
}