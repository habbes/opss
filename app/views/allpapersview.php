<?php

class AllPapersView extends LoggedInView
{
	public function render()
	{
		$this->data->pageTitle = "All Papers";
		$this->data->pageHeading = "All Papers";
		$this->setActiveNavLink("Papers", "All");
		$this->data->recordsTable = $this->read("papers-table");
		$this->data->pageContent = $this->read("records-table-container");
		$this->showBase();
	}
}