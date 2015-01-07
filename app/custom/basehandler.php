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
}