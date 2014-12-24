<?php

class RegistrationHandler extends RequestHandler
{
	private function showPage()
	{
		$this->viewParams->countries = SysDataList::get("countries-en");
		$this->viewParams->titles = SysDataList::get("titles-en");
		$this->viewParams->languages = SysDataList::get("languages-en");
		$researchVals = array_keys(PaperGroup::getValues());
		sort($researchVals);
		$this->viewParams->researchAreaValues = $researchVals;
		$this->viewParams->researchAreaNames = PaperGroup::getValues();
		$this->renderView("Registration");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		
		$this->viewParams->form = new DataObject($_POST);
		
		try {
			$errors = [];
			
			$user = User::create(UserType::RESEARCHER);
			//properties common to all user types
			$user->setTitle($this->trimPostVar("title"));
			$user->setFirstName($this->trimPostVar("firstname"));
			$user->setLastName($this->trimPostVar("lastname"));
			$user->setUsername($this->trimPostVar("username"));
			$user->setEmail($this->trimPostVar("email"));
			$pass = $this->postVar("password");
			$passConfirm = $this->postVar("password-confirm");
			if($pass != $passConfirm){
				$errors[] = ValidationError::USER_PASSWORDS_DONT_MATCH;
			}
				
			$user->setPassword($this->postVar("password"));
			
			//properties required for researchers
			switch($this->trimPostVar("gender")){
				case "male":
					$gender = UserGender::MALE;
					break;
				case "female":
					$gender = UserGender::FEMALE;
					break;
				default:
					$gender = 0;
			}
			$user->setGender($gender);
			$user->setAddress($this->trimPostVar("address"));
			$user->setResidence($this->trimPostVar("residence"));
			$user->setNationality($this->trimPostVar("nationality"));
			$collabArea = (int) $this->postVar("collaborative-area");
			$thematicArea = (int) $this->postVar("thematic-area");
			if(!PaperGroup::isValue($collabArea))
				$errors[] = ValidationError::COLLAB_AREA_INVALID;
			if(!PaperGroup::isValue($thematicArea))
				$errors[] = ValidationError::THEMATIC_AREA_INVALID;
			
			if(!empty($errors))
				throw new ValidationException($errors);
			$user->save();
			$user->addCollaborativeArea((int) $this->postVar("collaborative-area"));
			$user->addThematicArea((int) $this->postVar("thematic-area"));
		}
		catch(ValidationException $e) {
			echo "Form Errors<br>";
			foreach($e->getErrors() as $error)
				echo "$error <br>";
			
		}
		catch(Exception $e) {
			echo "Errors: ".$e->getMessage()."<br>";
		}
		
		$this->showPage();
		
		
	}
}