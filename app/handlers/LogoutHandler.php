<?php
class LogoutHandler extends LoggedInHandler
{
	public function get()
	{
		$this->logout();
		$this->localRedirect("login");
		exit;
	}
}