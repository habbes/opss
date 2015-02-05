<?php
class ResearchersView extends LoggedInView{
	public function render(){
		$this->data->pageTitle = "Researchers";
		$this->data->pageHeading = "Researchers";
		$this->setActiveNavLink("Users", "Researchers");
		$this->data->pageContent = $this->read("researchers-table");
		$this->showBase();
	}
}