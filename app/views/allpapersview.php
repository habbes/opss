<?php

class AllPapersView extends LoggedInView
{
	public function render()
	{
		$this->data->pageTitle = "All Papers";
		$this->data->pageHeading = "All Papers";
		$this->setActiveNavLink("Papers", "All");
		//show search form for admin
		$this->data->searchEndpoint = "papers";
		$this->data->searchUrl = "papers";
		$this->data->searchFieldId = "papers-search-field";
		$this->data->tableContainerId = "papers-table-container";
		$this->data->recordsTable = $this->read("papers-table");
		$this->data->pageContent = $this->read("records-table-container");
		
		$this->showBase();
	}
}