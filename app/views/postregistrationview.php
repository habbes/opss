<?php

class PostRegistrationView extends BaseView
{
	public function render($params)
	{
		$this->data->pageTitle = "Post Registration";
		$this->data->pageHeading = "Registration Successful";
		$this->data->pageContent = $this->read("post-registration");
		$this->showBase();
	}
}