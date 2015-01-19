<?php

class HomeView extends PaperView
{
	
	private $homePageItems = [];
	
	private function addHomePageItem($template)
	{
		$this->homePageItems[] = $this->read($template);
	}
	
	public function render()
	{
		
		if($this->data->user->isAdmin() && $this->data->paper->getStatus() == Paper::STATUS_VETTING){
			$this->addVetReviewForm();
		}
		
		$this->setActivePaperNavLink("Home");
		$this->data->paperHomePageItems = $this->homePageItems;
		$this->data->paperPageContent = $this->read("paper-home");
		$this->showBase();
	}
	
	private function addVetReviewForm()
	{
		$this->data->form or $this->data->form = new DataObject();
		$this->data->errors or $this->data->errors = new DataObject();
		$this->addHomePageItem("paper-vet-review");
	}
}