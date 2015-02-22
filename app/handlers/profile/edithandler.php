<?php

class EditHandler extends LoggedInHandler
{
	
	private function showPage()
	{
		$this->viewParams->titles = SysDataList::get("titles-en");
		$this->viewParams->countries = SysDataList::get("countries-en");
		$researchVals = array_keys(PaperGroup::getValues());
		sort($researchVals);
		$this->viewParams->researchAreaValues = $researchVals;
		$this->viewParams->researchAreaNames = PaperGroup::getValues();		
		$this->renderView("profile/Edit");
	}
	
	public function get()
	{
		$form = new DataObject();
		$form->email = $this->user->getEmail();
		$form->firstname = $this->user->getFirstName();
		$form->lastname = $this->user->getLastName();
		$form->title = $this->user->getTitle();
		
		if($this->role->hasGender())
			$form->gender = $this->user->getGender();
		if($this->role->hasAddress())
			$form->address = $this->user->getAddress();
		if($this->role->hasNationality())
			$form->nationality = $this->user->getNationality();
		if($this->role->hasResidence())
			$form->residence = $this->user->getResidence();
		if($this->role->hasAreaOfSpecialization()){
			$form->set("thematic-area", $this->user->getThematicAreas()[0]);
			$form->set("collaborative-area", $this->user->getCollaborativeAreas()[0]);
		}
		
		$this->viewParams->form = $form;
		$this->showPage();		
	}
	
	public function post()
	{
		$form = new DataObject();
		try {
			
			$errors = [];
			$user = $this->user;
			$role = $user->getRole();
			
			$curEmail = $user->getEmail();
			$newEmail = $this->trimPostVar("email", $curEmail);
			$form->email = $newEmail;
			if($newEmail != $curEmail)
				$user->setEmail($newEmail);
			
			$curFName = $user->getFirstName();
			$newFName = $this->trimPostVar("firstname", $curFName);
			$form->firstname = $newFName;
			if($newFName != $curFName)
				$user->setFirstName($newFName);
			
			$curLName = $user->getLastName();
			$newLName = $this->trimPostVar("lastname", $curLName);
			$form->lastname = $newLName;
			if($newLName != $curLName)
				$user->setLastName($newLName);
			
			$curTitle = $user->getTitle();
			$newTitle = $this->trimPostVar("title", $curTitle);
			$form->title = $newTitle;
			if($newTitle != $curTitle)
				$user->setTitle($newTitle);
			
			//password
			
			$password = $this->PostVar("password");
			if($password){
				$curPass = $this->postVar("current-password");
				$confirmPass = $this->PostVar("password-confirm");
				if($password != $confirmPass)
					$errors[] = OperationError::USER_PASSWORDS_DONT_MATCH;
				else {
					if(!$user->changePassword($password, $curPass))
						$errors[] = OperationError::USER_PASSWORD_INCORRECT;					
				}
			}
			
			if($role->hasGender()){
				$curGender = $user->getGender();
				$newGender = (int) $this->postVar("gender", $curGender);
				$form->gender = $newGender;
				if($newGender != $curGender)
					$user->setGender($newGender);				
			}
			if($role->hasAddress()){
				$curAddress = $user->getAddress();
				$newAddress = $this->trimPostVar("address", $curAddress);
				$form->address = $newAddress;
				if($newAddress != $curAddress)
					$user->setAddress($newAddress);
			}
			if($role->hasResidence()){
				$curResidence = $user->getResidence();
				$newResidence = $this->trimPostVar("residence", $curResidence);
				$form->residence = $newResidence;
				if($newResidence != $curResidence)
					$user->setResidence($newResidence);
			}
			if($role->hasNationality()){
				$curNationality = $user->getNationality();
				$newNationality = $this->trimPostVar("nationality", $curNationality);
				$form->nationality = $newNationality;
				if($newNationality != $curNationality)
					$user->setNationality($newNationality);
			}
			
			if($role->hasAreaOfSpecialization()){
				$curCollabArea = $user->getCollaborativeAreas()[0];
				$newCollabArea = (int) $this->postVar("collaborative-area", $curCollabArea);
				$curThematicArea = $user->getThematicAreas()[0];
				$newThematicArea = (int) $this->postVar("thematic-area", $curThematicArea);
				if(!PaperGroup::isValue($newCollabArea))
					$errors[] = OperationError::COLLAB_AREA_INVALID;
				if(!PaperGroup::isValue($newThematicArea))
					$errors[] = OperationError::THEMATIC_AREA_INVALID;
			}
			
			if(!empty($errors))
				throw new OperationException($errors);
			
			$user->save();
			
			if($role->hasAreaOfSpecialization()){
				//replace current thematic and/or collab area
				//TODO: instead of deleting, make it possible to delete one
				//TODO: and to add without deleting
				if($newCollabArea != $curCollabArea){
					$user->deleteAllCollaborativeAreas();
					$user->addCollaborativeArea($newCollabArea);
				}
				if($newThematicArea != $curThematicArea){
					$user->deleteAllThematicAreas();
					$user->addThematicArea($newThematicArea);
				}
			}
			
			//send email activation if email changed
			if(!$user->isEmailActivated()){
				$ea = EmailActivation::create($user, $user->getEmail());
				EmailActivationEmail::create($user, $ea->getCode())->send();
			}
			
			$this->saveResultMessage("Changes saved successfully.", "success");
			$this->localRedirect("profile");
			
		}
		catch(OperationException $e){
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
					case OperationError::USER_PASSWORD_INCORRECT:
						$errors->set("current-password", "This password is incorrect.");
						break;
					
				}//end switch
			}//end for
			$this->setResultMessage("Please correct the indicated errors.", "error");
			$this->viewParams->form = $form;
			$this->viewParams->errors = $errors;
			$this->showPage();
		}
	}
}