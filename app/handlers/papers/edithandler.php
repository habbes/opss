<?php

class EditHandler extends PaperHandler
{
	
	private function showPage()
	{
		$form = new DataObject();
		$form->title = $this->postVar("title")? 
			$this->postVar("title") : $this->paper->getTitle();
		$form->country = $this->postVar("country")? 
			$this->postVar("country") : $this->paper->getCountry();
		$form->language = $this->postVar("language")?
			$this->postVar("language") : $this->paper->getLanguage();
		$this->viewParams->form = $form;
		$this->viewParams->countries = SysDataList::get("countries-en");
		$this->viewParams->languages = SysDataList::get("languages-en");
		
		if($this->session()->paperChangesSaved){
			$this->setResultMessage("Changes saved successfully.", "success");
			$this->session()->deleteData("paperChangesSaved");
		}
		
		if($this->session()->paperUnchanged){
			$this->setResultMessage("No changes detected.", "normal");
			$this->session()->deleteData("paperUnchanged");
		}
			
		$this->renderView("papers/Edit");
	}
	
	private function redirectSuccess()
	{
		$this->session()->paperChangesSaved = true;
		$this->paperLocalRedirect("edit");
	}
	
	private function redirectUnchanged()
	{
		$this->session()->paperUnchanged = true;
		$this->paperLocalRedirect("edit");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function handleDetailsChanges()
	{
		try {
			$changesMade = false;
			$oldTitle = $this->paper->getTitle();
			$oldLanguage = $this->paper->getLanguage();
			$oldCountry = $this->paper->getCountry();
			
			$newTitle = $this->trimPostVar("title");
			$newLanguage = $this->trimPostVar("language");
			$newCountry = $this->trimPostVar("country");
			
			$this->paper->setTitle($newTitle);
			$this->paper->setLanguage($newLanguage);
			$this->paper->setCountry($newCountry);
			
			$this->paper->save();
			
			if($oldTitle != $this->paper->getTitle()){
				PaperChange::createTitleChanged($this->paper, $oldTitle, $this->paper->getTitle())->save();
				$changesMade = true;
			}
			
			if($oldLanguage != $this->paper->getLanguage()){
				PaperChange::createLanguageChanged($this->paper, $oldLanguage, $this->paper->getLanguage())->save();
				$changesMade = true;
			}
			
			if($oldCountry != $this->paper->getCountry()){
				PaperChange::createCountryChanged($this->paper, $oldCountry, $this->paper->getCountry())->save();
				$changesMade = true;
			}
			
			if($changesMade)
				$this->redirectSuccess();
			else
				$this->redirectUnchanged();
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::PAPER_TITLE_EMPTY:
						$errors->title = "You did not specify a title.";
						break;
					case OperationError::PAPER_LANGUAGE_EMPTY:
						$errors->language = "You did not specify a language.";
						break;
					case OperationError::PAPER_COUNTRY_EMPTY:
						$errors->country = "You did not specify a country.";
						break;
				}
			}
			
			$this->viewParams->errors = $errors;
			$this->setResultMessage("Please correct the highlighted errors.", "error");
			$this->showPage();
			
		}
	}
	
	public function handleFileChanges()
	{
		try {
			$changeMade = false;
			$file = $this->fileVar("document");
			$cover = $this->fileVar("cover");
			if($file->name){
				$oldFile = $this->paper->getFile();
				$this->paper->setFile($file->name, $file->tmp_name, true);
				$newFile = $this->paper->getFile();
				$this->paper->save();
				PaperChange::createFileChanged($this->paper, $oldFile, $newFile)->save();
				$changeMade = true;
			}
			if($cover->name){
				$oldCover = $this->paper->getCover();
				$this->paper->setCover($cover->name, $cover->tmp_name, true);
				$newCover = $this->paper->getCover();
				$this->paper->save();
				PaperChange::createCoverChanged($this->paper, $oldCover, $newCover)->save();
				$changeMade = true;
				
			}
			
			if($changeMade)
				$this->redirectSuccess();
			else
				$this->redirectUnchanged();
		}
		catch(OperationException $e){
			$this->setResultMessage("Error occured.");
			$this->showPage();
		}
	}
	
	public function handleAddAuthor()
	{
		try {
			$name = $this->trimPostVar("name");
			$email = $this->trimPostVar("email");
			$reasons = $this->trimPostVar("reasons");
			if(!$reasons)
				throw new OperationException(["reasonsEmpty"]);
			$this->paper->addAuthor($name, $email);
			$this->paper->save();
			PaperChange::createAuthorAdded($this->paper, $name, $email);
			$this->redirectSuccess();
		}
		catch(OperationException $e){
			$errors = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::USER_EMAIL_INVALID:
						$errors->email = "You entered an incorrect email format.";
						break;
					case OperationError::AUTHOR_NAME_EMPTY:
						$errors->name = "You did not specify a name.";
						break;
					case OperationError::PAPER_MAX_AUTHORS_REACHED:
						$errors->form = "The paper already has the maximum number of allowed co-authors.";
						break;
					case "reasonsEmpty":
						$errors->reasons = "You did not specify reasons.";
						break;
				}
			}
			$this->viewParams->addAuthorForm = new DataObject($_POST);
			$this->viewParams->addAuthorErrors = $errors;
			$this->showPage();
		}
	}
}