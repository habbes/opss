<?php
class ReviewersView extends LoggedInView{
	public function render(){
		$this->data->pageTitle = "Reviewers";
		$this->data->pageHeading = "Reviewers";
		$this->setActiveNavLink("Users", "Reviewers");
		
		$this->data->searchEndpoint = "reviewers";
		$this->data->searchUrl = "reviewers/search";
		$this->data->searchFieldId = "reviewers-search-field";
		$this->data->tableContainerId = "reviewers-table-container";
		$this->data->recordsTable = $this->read("reviewers-table");
		$this->data->pageContent = $this->read("records-table-container");
		$this->showBase();
	}
}