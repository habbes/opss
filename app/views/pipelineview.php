<?php

class PipelineView extends LoggedInView
{
	public function render()
	{
		$this->data->pageTitle = "Presentation Pipeline";
		$this->data->pageHeading = "Presentation Pipeline";
		$this->setActiveNavLink('Papers', 'Presentation Pipeline');
		//show search form for admin
		$this->data->searchFieldId = "papers-search-field";
		$this->data->tableContainerId = "papers-table-container";
		$this->data->recordsTable = $this->read("presentation-pipeline");
		$this->data->pageContent = $this->read("records-table-container");
		
		$this->showBase();
	}
}