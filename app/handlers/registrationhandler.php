<?php

class RegistrationHandler extends LoggedOutHandler
{
	
	/**
	 * 
	 * @var RegInvitation
	 */
	private $invitation;
	
	private function checkInvitation()
	{
		$code = $this->getVar("invitation");
		if($code){
			$this->invitation = RegInvitation::findValidByCode($code);
			if(!$this->invitation){
				$this->setResultMessage("Invalid invitation code.", "error");
				$this->showResearcherRegPage();
			}
		}
	}
	
	private function showResearcherRegPage()
	{
		//check for invitation
		$this->viewParams->countries = SysDataList::get("countries-en");
		$this->viewParams->titles = SysDataList::get("titles-en");
		$this->viewParams->languages = SysDataList::get("languages-en");
		$researchVals = array_keys(PaperGroup::getValues());
		sort($researchVals);
		$this->viewParams->researchAreaValues = $researchVals;
		$this->viewParams->researchAreaNames = PaperGroup::getValues();
		$this->renderView("Registration");
	}
	
	private function showAdminRegPage()
	{
		$this->viewParams->titles = SysDataList::get("titles-en");
		$this->viewParams->formType = "admin";
		$this->viewParams->form = new DataObject();
		if($this->invitation){
			$this->viewParams->form->email = $this->invitation->getEmail();
			$names = explode(' ', $this->invitation->getName());
			$this->viewParams->form->firstname = $names[0];
			if(count($names) > 1){
				$this->viewParams->form->lastname = $names[1];
			}
			$this->viewParams->form->username = implode('', $names );
		}
		$this->renderView("Registration");
	}
	
	private function showRegPage()
	{
		if($this->invitation){
			switch($this->invitation->getUserType()){
				case UserType::RESEARCHER:
					$this->showResearcherRegPage();
					break;
				case UserType::ADMIN:
				case UserType::REVIEWER:
					$this->showAdminRegPage();
					break;
			}
		}
		else {
			$this->showResearcherRegPage();
		}
	}
	
	private function showPostRegPage()
	{
		$this->renderView("PostRegistration");
	}
	
	private function handleRegistration()
	{
		$this->checkInvitation();
		$this->viewParams->form = new DataObject($_POST);
		try {
			$errors = [];
			
			$userType = $this->invitation? $this->invitation->getUserType() : UserType::RESEARCHER;
			$user = User::create($userType);
			//properties common to all user types
			$user->setTitle($this->trimPostVar("title"));
			$user->setFirstName($this->trimPostVar("firstname"));
			$user->setLastName($this->trimPostVar("lastname"));
			$user->setUsername($this->trimPostVar("username"));
			$user->setEmail($this->trimPostVar("email"));
			$pass = $this->postVar("password");
			$passConfirm = $this->postVar("password-confirm");
			if($pass != $passConfirm){
				$errors[] = OperationError::USER_PASSWORDS_DONT_MATCH;
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
			$role = $user->getRole();
			if($role->hasGender())
				$user->setGender($gender);
			if($role->hasAddress())
				$user->setAddress($this->trimPostVar("address"));
			if($role->hasResidence())
				$user->setResidence($this->trimPostVar("residence"));
			if($role->hasNationality())
				$user->setNationality($this->trimPostVar("nationality"));
			
			if($role->hasAreaOfSpecialization()){
				$collabArea = (int) $this->postVar("collaborative-area");
				$thematicArea = (int) $this->postVar("thematic-area");
				if(!PaperGroup::isValue($collabArea))
					$errors[] = OperationError::COLLAB_AREA_INVALID;
				if(!PaperGroup::isValue($thematicArea))
					$errors[] = OperationError::THEMATIC_AREA_INVALID;
			}				
			if(!empty($errors))
				throw new OperationException($errors);
			
			$user->save();
			
			if($role->hasAreaOfSpecialization()){
				$user->addCollaborativeArea((int) $this->postVar("collaborative-area"));
				$user->addThematicArea((int) $this->postVar("thematic-area"));
			}
			
			//send welcome message
			$msg = WelcomeMessage::create($user);
			$msg->send();
			
			//notify admins
			foreach(Admin::findAll() as $admin)
			{
				$msg = UserRegisteredMessage::create($user);
				$msg->sendTo($admin);
			}
			
			//send activation email
			$ea = EmailActivation::create($user);
			$ea->save();
			$mail = WelcomeEmail::create($user, $ea->getCode());
			$mail->send();
			
			if($this->invitation){
				$this->invitation->register($user);
			}
			
			//start paper review period
			if($this->invitation && 
					$this->invitation->getUserType() == UserType::REVIEWER && $this->invitation->getPaper()){
				$paper = $this->invitation->getPaper();
				$paper->sendForReview($user, $this->invitation->getAdmin());
				
				//notify reviewer
				PaperSentForReviewMessage::create($user, $paper, $user)->send();
				//notify researcher
				PaperSentForReviewMessage::create($paper->getResearcher(), $paper, $user)->send();
				//notify admins
				foreach(Admin::findAll() as $admin){
					PaperSentForReviewMessage::create($admin, $paper, $user)->send();
				}
			}
			
			Session::instance()->registeredUserId =  $user->getId();
			$this->showPostRegPage();
				
		}
		catch(OperationException $e) {
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::USER_FIRST_NAME_EMPTY:
						$errors->firstname = "First name is required";
						break;
					case OperationError::USER_LAST_NAME_EMPTY:
						$errors->lastname = "Last name is required";
						break;
					case OperationError::USER_GENDER_INVALID:
						$errors->gender = "Gender is required";
						break;
					case OperationError::USER_NATIONALITY_EMPTY:
						$errors->nationality = "Country of nationality is required";
						break;
					case OperationError::USER_RESIDENCE_EMPTY:
						$errors->residence = "Country of residence is required";
						break;
					case OperationError::USER_ADDRESS_EMPTY:
						$errors->address = "Address is required";
						break;
					case OperationError::COLLAB_AREA_INVALID:
						$errors->set("collaborative-area", "Invalid choice. Please select one of the provided.");
						break;
					case OperationError::THEMATIC_AREA_INVALID:
						$errors->set("thematic-area", "Invalid choice. Please select one of the provided.");
						break;
					case OperationError::USER_USERNAME_INVALID:
						$errors->username = "Invalid username. Please user only letters, numbers, _ and -";
						break;
					case OperationError::USER_USERNAME_UNAVAILABLE:
						$errors->username = "This username is not available, please choose a different one.";
						break;
					case OperationError::USER_EMAIL_INVALID:
						$errors->email = "Invalid email address. An email address should be of the form johndoe@example.com";
						break;
					case OperationError::USER_EMAIL_UNAVAILABLE:
						$errors->email = "This email is not available, please choose a different one.";
						break;
					case OperationError::USER_PASSWORD_INVALID:
						$errors->password = "Invalid password. The password should have 6 to 50 characters including "
								."letters, numbers, and special characters like *, !, etc.";
								break;
					case OperationError::USER_PASSWORDS_DONT_MATCH:
						$errors->set("password-confirm", "This does not match the entered password");
						break;
				}
				
				$this->setResultMessage("Please correct the indicated errors.", "error");
			}
		
			$this->viewParams->errors = $errors;
		}
		catch(Exception $e) {
			echo "Errors: ".$e->getMessage()."<br>";
		}
		
		$this->showRegPage();
	}
	
	private function resendActivation()
	{
		try {
			$user = User::findById(Session::instance()->registeredUserId);
			if(!$user)
				throw new OperationException(["UserNotFound"]);
			//send activation email
			$ea = EmailActivation::create($user);
			$ea->save();
			$mail = WelcomeEmail::create($user, $ea->getCode());
			$mail->send();
		}
		catch(OperationException $e) {
			foreach($e->getErrors() as $error){
				switch($error){
					case "UserNotFound":
						$this->setResultMessage("Error occured while trying to send email. Email was not sent.","error");
						break;
				}
			}
		}
		$this->showPostRegPage();
		
	}
	
	public function get()
	{
		if(Session::instance()->registeredUserId)
			unset(Session::instance()->registeredUserId);
		$this->checkInvitation();
		$this->showRegPage();
	}
	
	public function post()
	{
		
		if(Session::instance()->registerdUserId)
			$this->resendActivation();
		else		
			$this->handleRegistration();
		
		
	}
}