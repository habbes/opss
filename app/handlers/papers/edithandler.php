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
			
		$this->renderView("papers/Edit");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function handleDetailsChanges()
	{
		try {
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
			}
			
			if($oldLanguage != $this->paper->getLanguage()){
				PaperChange::createLanguageChanged($this->paper, $oldLanguage, $this->paper->getLanguage())->save();
			}
			
			if($oldCountry != $this->paper->getCountry()){
				PaperChange::createCountryChanged($this->paper, $oldCountry, $this->paper->getCountry())->save();
			}
			
			$this->session()->paperChangesSaved = true;
			$this->localRedirect("/papers/".$this->paper->getIdentifier()."/edit");
			
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
}