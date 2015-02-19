<?php

class AllPapersView extends LoggedInView
{
	public function render()
	{
		$this->data->pageTitle = "All Papers";
		$this->data->pageHeading = "All Papers";
		$this->setActiveNavLink("Papers", "All");
		//show search form for admin
		if($this->data->user->isAdmin()){
			$this->data->searchFieldId = "papers-search-field";
			$this->data->tableContainerId = "papers-table-container";
			$this->data->recordsTable = $this->read("papers-table");
			$this->data->pageContent = $this->read("records-table-container");
		}
		else {
			//TODO: Allow search form to all when advanced Searcher is implemented
			$this->data->pageContent = $this->read("papers-table");
		}
		$this->showBase();
	}
}