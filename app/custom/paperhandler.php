<?php

/**
 * base class for handlers for pages for viewing and manipulating a paper
 * @author Habbes
 *
 */
abstract class PaperHandler extends LoggedInHandler
{
	
	/**
	 * 
	 * @var Paper
	 */
	protected $paper;
	
	/**
	 * indicates whether this particular sub-page of the paper dashboard should be visible,
	 * if not, the user will be redirected to the paper's home page
	 * @return boolean
	 */
	protected function isPageVisible()
	{
		return true;
	}
	
	/**
	 * redirects relatively to the root/home page of the current paper
	 * @param string $url
	 */
	protected function paperLocalRedirect($url = "")
	{
		if($url[0] != "/") $url = "/$url";
		$this->localRedirect("papers/".$this->paper->getIdentifier().$url);
	}
	
	/**
	 * ensures the user has access to this paper and redirects otherwise
	 */
	protected function assertPaperAccess()
	{
		if(!$this->user->getRole()->hasAccessToPaper($this->paper)){
			$this->localRedirect("");
		}
		if(!$this->isPageVisible()){
			$this->localPaperRedirect("");
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
		$this->viewParams->paper = $paper;
		$this->viewParams->paperBaseUrl = URL_PAPERS . "/" . $this->paper->getIdentifier();
		
	}
}