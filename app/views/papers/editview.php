<?php

class EditView extends PaperView
{
	public function render()
	{
		$this->data->form or $this->data->form = new DataObject();
		$this->data->errors or $this->data->errors = new DataObject();
		$this->setActivePaperNavLink("Edit");
		$this->data->paperPageContent = $this->read("paper-edit-form");
		$this->showBase();
	}
}