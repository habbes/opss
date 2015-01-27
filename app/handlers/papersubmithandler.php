<?php

class PaperSubmitHandler extends ResearcherHandler
{
	
	public function showPage()
	{
		$this->viewParams->countries = SysDataList::get("countries-en");
		$this->viewParams->languages = SysDataList::get("languages-en");
		$this->renderView("SubmitPaper");
	}
	
	public function get()
	{
		$this->showPage();
	}
	
	public function post()
	{
		$paper = Paper::create($this->user);
		try {
			$errors = [];
			$paper->setTitle($this->trimPostVar("title"));
			$paper->setLanguage($this->trimPostVar("language"));
			$paper->setCountry($this->trimPostVar("country"));
			
			//file checks
			$document = $this->fileVar("document");
			if($document){
				$paper->setFile($document->name, $document->tmp_name);
			}
			
			$cover = $this->fileVar("cover");
			if($cover){
				$paper->setCover($cover->name, $cover->tmp_name);
			}
			
			$paper->save();
			
			//add authors
			$author1Name = $this->trimPostVar("author1-name");
			$author1Email = $this->trimPostVar("author1-email");
			
			//if email is provided, name should also be provided
			if($author1Email && !$author1Name)
				$errors[] = "Author1NameEmpty"; 
			
			if($author1Name){
				if(!$author1Email || !User::isValidEmail($author1Email)){
					$errors[] = "Author1EmailInvalid";
				}
				if(empty($errors))
					$paper->addAuthor($author1Name, $this->trimPostVar("author1-email"));
			}
			
			$author2Name = $this->trimPostVar("author2-name");
			$author2Email = $this->trimPostVar("author2-email");
			
			if($author2Email && !$author1Email)
				$errors[] = "Author2NameEmpty";
			
			if($author2Name){
				if(!$author2Email || !User::isValidEmail($author2Email)){
					$errors[] =  "Author2EmailInvalid";
				}
				if(empty($errors))
					$paper->addAuthor($author2Name, $author2Email);
			}
			
			if(!empty($errors))
				throw new OperationException($errors);
			
			//record paper change
			PaperChange::createSubmitted($paper)->save();
			
			//send for vetting
			//TODO: this should be deferred until grace period is over and should be ran
			//by a scheduled Task Runner
			$paper->sendForVetting();
			
			
			//notify all admins
			foreach(Admin::findAll() as $admin)
			{
				$msg = PaperSubmittedMessage::create($paper, $admin);
				$msg->send();
			}
			
			//notify researcher
			$msg = PaperSubmittedMessage::create($paper, $this->user);
			$msg->send();
			
			//redirect to paper
			$this->localRedirect("/papers/".$paper->getIdentifier());
			
		}
		catch (OperationException $e){
			$formerror = new DataObject();
			foreach($e->getErrors() as $error){
				switch($error){
					case OperationError::PAPER_TITLE_EMPTY:
						$formerror->title = "Please enter the title of the paper.";
						break;
					case OperationError::PAPER_LANGUAGE_EMPTY:
						$formerror->language = "Please specify the language of the paper.";
						break;
					case OperationError::PAPER_COUNTRY_EMPTY:
						$formerror->country = "Please specify the country of research.";
						break;
					case "Author1NameEmpty":
						$formerror->set("author1-name", "Please specify the name of the co-author.");
						break;
					case "Author1EmailInvalid":
						$formerror->set("author1-email", "You entered an invalid email address.");
						break;
					case "Author2NameEmpty":
						$formerror->set("author2-name", "Please specify the name of the co-author.");
						break;
					case "Author2EmailEmpty":
						$formerror->set("author2-email", "You entered an invalid email address.");
						break;
					
				}
				
				//delete paper if it was saved
				if($paper->isInDb()){
					$paper->delete();
				}
			}
			$this->viewParams->errors = $formerror;
			$this->viewParams->form = new DataObject($_POST);
			$this->setResultMessage("Please correct the highlighted errors.", "error");
			
			$this->showPage();
		}
		
		
		$this->showPage();
	}
}