<?php

class ResubmitHandler extends PaperHandler
{
	public function post()
	{
		switch($this->paper->getStatus()){
			case Paper::STATUS_VETTING_REVISION:
				$this->vettingResubmit();
				break;
				
		}
	}
	
	public function vettingResubmit()
	{
		$this->paper->vettingResubmit();
		PaperChange::createResubmitted($this->paper)->save();
		//TODO: send notification messages & emails
		$this->paperLocalRedirect();
	}
}