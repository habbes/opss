<?php

/**
 * base class for handlers for pages for viewing and manipulating a paper
 * @author Habbes
 *
 */
abstract class PaperHandler extends LoggedInHandler
{
	
	protected $paper;
	
	/**
	 * ensures the user has access to this paper and redirects otherwise
	 */
	protected function assertPaperAccess()
	{
		if(!$this->user->getRole()->hasAccessToPaper($this->paper)){
			$this->localRedirect("");
		}
	}
	
	public function onCreate($identifier)
	{
		$paper = Paper::findByIdentifier($identifier);
		if(!$paper)
			$this->localRedirect("papers/all?not-found=true");
		$this->paper = $paper;
		parent::onCreate();
		$this->assertPaperAccess();
		
	}
}