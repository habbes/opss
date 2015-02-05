<?php
class AdminsView extends LoggedInView{
	public function render(){
		$this->data->pageTitle = "Admins";
		$this->data->pageHeading = "Admins";
		$this->setActiveNavLink("Users", "Admins");
		$this->data->pageContent = $this->read("admins-table");
		$this->showBase();
	}
}