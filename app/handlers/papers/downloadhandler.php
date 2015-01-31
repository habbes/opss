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
	
	/**
	 * @param string $identifier
	 * @param int $changeId id of the PaperChange containing the requested version
	 */
	public function downloadPaperVersion($identifier, $changeId)
	{
		$change = $this->paper->getChangeById($changeId);
		if($change){
			$file = null;
			switch($change->getAction()){
				case PaperChange::ACTION_SUBMITTED:
				case PaperChange::ACTION_RESUBMITTED:
					$file = File::findById($change->getArg("fileId"));
					break;
				case PaperChange::ACTION_FILE_CHANGED:
					$file = File::findById($change->getArg("toId"));
					break;
			}
			
			$file->sendResponse();
			
		}
	}
	
	/**
	 * @param string $identifier
	 * @param int $changeId id of the PaperChange containing the requested version
	 */
	public function downloadCoverVersion($identifier, $changeId)
	{
		$change = $this->paper->getChangeById($changeId);
		if($change){
			$file = null;
			switch($change->getAction()){
				case PaperChange::ACTION_SUBMITTED:
				case PaperChange::ACTION_RESUBMITTED:
					$file = File::findById($change->getArg("coverId"));
					break;
				case PaperChange::ACTION_COVER_CHANGED:
					$file = File::findById($change->getArg("toId"));
					break;
			}
				
			$file->sendResponse();
				
		}
	}
}