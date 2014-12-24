<?php

class RegistrationHandler extends LoggedOutHandler
{
	private function showRegPage()
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
	
	private function showPostRegPage()
	{
		$this->renderView("PostRegistration");
	}
	
	private function handleRegistration()
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
				
			//send activation email
			$ea = EmailActivation::create($user);
			$mail = WelcomeEmail::create($user, $ea->getCode());
			$mail->send();
				
			Session::instance()->registerdUserId =  $user->getId();
			$this->showPostRegPage();
				
		}
		catch(ValidationException $e) {
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case ValidationError::USER_FIRST_NAME_EMPTY:
						$errors->firstname = "First name is required";
						break;
					case ValidationError::USER_LAST_NAME_EMPTY:
						$errors->lastname = "Last name is required";
						break;
					case ValidationError::USER_GENDER_INVALID:
						$errors->gender = "Gender is required";
						break;
					case ValidationError::USER_NATIONALITY_EMPTY:
						$errors->nationality = "Country of nationality is required";
						break;
					case ValidationError::USER_RESIDENCE_EMPTY:
						$errors->residence = "Country of residence is required";
						break;
					case ValidationError::USER_ADDRESS_EMPTY:
						$errors->address = "Address is required";
						break;
					case ValidationError::COLLAB_AREA_INVALID:
						$errors->set("collaborative-area", "Invalid choice. Please select one of the provided.");
						break;
					case ValidationError::THEMATIC_AREA_INVALID:
						$errors->set("thematic-area", "Invalid choice. Please select one of the provided.");
						break;
					case ValidationError::USER_USERNAME_INVALID:
						$errors->username = "Invalid username. Please user only letters, numbers, _ and -";
						break;
					case ValidationError::USER_USERNAME_UNAVAILABLE:
						$errors->username = "This username is not available, please choose a different one.";
						break;
					case ValidationError::USER_EMAIL_INVALID:
						$errors->email = "Invalid email address. An email address should be of the form johndoe@example.com";
						break;
					case ValidationError::USER_EMAIL_UNAVAILABLE:
						$errors->email = "This email is not available, please choose a different one.";
						break;
					case ValidationError::USER_PASSWORD_INVALID:
						$errors->password = "Invalid password. The password should have 6 to 50 characters including "
								."letters, numbers, and special characters like *, !, etc.";
								break;
					case ValidationError::USER_PASSWORDS_DONT_MATCH:
						$errors->set("password-confirm", "This does not match the entered password");
						break;
				}
			}
		
			$this->viewParams->errors = $errors;
		}
		catch(Exception $e) {
			echo "Errors: ".$e->getMessage()."<br>";
		}
		
		$this->showPage();
	}
	
	private function resendActivation()
	{
		$user = User::findById(Session::instance()->registerdUserId);
		//send activation email
		$ea = EmailActivation::create($user);
		$mail = WelcomeEmail::create($user, $ea->getCode());
		$mail->send();
		$this->showPostRegPage();
		
	}
	
	public function get()
	{
		if(!Session::instance()->registeredUserId)
			$this->showRegPage();
		else
			$this->showPostRegPage();
	}
	
	public function post()
	{
		
		if(Session::instance()->registerdUserId)
			$this->resendActivation();
		else		
			$this->handleRegistration();
		
		
	}
}