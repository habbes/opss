<?php

class SendToCommsHandler extends PaperHandler
{
	public function post()
	{
		$this->paper->sendToCommunications();
		$this->paper->save();
		$this->saveResultMessage("Paper sent to communications successfully.", "success");
		$this->paperLocalRedirect();
	}
}