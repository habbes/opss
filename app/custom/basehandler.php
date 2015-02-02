<?php

/**
 * base class for request handlers used on this site
 * @author Habbes
 *
 */
class BaseHandler extends RequestHandler
{
	/**
	 * 
	 * @param string $message
	 * @param string $type
	 */
	protected function setResultMessage($message, $type = "normal")
	{
		$this->viewParams->resultMessage = $message;
		$this->viewParams->resultMessageType = $type;
	}
	
	/**
	 * save result message in session
	 * @param string $message
	 * @param string $type
	 */
	protected function saveResultMessage($message, $type = "normal")
	{
		$this->session()->resultMessage = $message;
		$this->session()->resultMessageType = $type;
	}
	
	/**
	 * set the result message that is saved in session
	 * @param boolean $keep whether to keep this message in session, otherwise it is deleted
	 */
	protected function setSavedResultMessage($keep = false)
	{
		$msg = $this->session()->resultMessage;
		if(!$msg) return;
		$type = $this->session()->resultMessageType;
		$this->setResultMessage($msg, $type);
		if(!$keep){
			unset($this->session()->resultMessage);
			unset($this->session()->resultMessageType);
		}
	}
}