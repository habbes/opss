<?php
class ReviewersView extends LoggedInView{
	public function render(){
		$this->data->pageTitle = "Reviewers";
		$this->data->pageHeading = "Reviewers";
		$this->setActiveNavLink("Users", "Reviewers");
		$this->data->pageContent = $this->read("reviewers-table");
		$this->showBase();
	}
}