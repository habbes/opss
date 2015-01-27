<?php

class DownloadHandler extends PaperHandler
{
	public function get()
	{
		$this->downloadPaper();
	}
	
	public function downloadPaper()
	{
		$this->paper->getFile()->sendResponse();
	}
	
	public function downloadCover()
	{
		if($this->role->canViewPaperCover()){
			$this->paper->getCover()->sendResponse();
		}
	}
}