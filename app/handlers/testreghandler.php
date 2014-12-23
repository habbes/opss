<?php

class TestRegHandler extends RequestHandler
{
	
	private function showPage()
	{
		$this->renderView("Reg");
	}
	
	public function get()
	{
		$user = User::findByUsername("habyhabbes");
		if($user){
			$this->viewParams->resultMessage = "Welcome, ".$user->getFullName();
		}
		$this->showPage();
	}
	
	public function post()
	{
		$user = User::create(UserType::RESEARCHER);
		
		$user->setUsername($this->postVar('username'));
		$user->setEmail($this->postVar('email'));
		$user->setPassword($this->postVar('password'));
		$user->setTitle($this->postVar('title'));
		$user->setFirstName($this->postVar("first"));
		$user->setLastName($this->postVar("last"));
		$user->setResidence($this->postVar("residence"));
		$user->setNationality($this->postVar("nationality"));
		$user->setGender((int)$this->postVar("gender"));
		
		try {
			$user->save();
			$email = new Email();
			$ea = EmailActivation::create($user);
			$ea->save();
			
			$email->setBodyFromTemplate("post_registration",
					["link"=>URL_ROOT."/code=".$ea->getCode(),
							"name"=>$user->getFullName(),
							"accountType"=>UserType::getString($user->getType())
					]);
			$user->sendEmail($email);
		}
		catch(ValidationException $e) {
			$this->viewParams->resultMessage = "Failed due to form errors";
			foreach($e->getErrors() as $error){
				$this->viewParams->resultMessage .= "<br>$error";
			}
		}
		catch(Exception $e) {
			$this->viewParams->resultMessage = "Internal errors: " . $e->getMessage();
			
		}
		
		
		$this->showPage();
	}
}