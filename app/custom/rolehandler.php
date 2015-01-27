<?php
/**
 * base class for handlers that restrict access only to specified roles
 * and denies access if the user is not of those roles
 * @author Habbes
 *
 */
abstract class RoleHandler extends LoggedInHandler
{
	/**
	 * get the only Roles that this handler grants access to
	 * @return array(number) elements are from UserType
	 */
	protected abstract function getAllowedRoles();
	
	protected function assertRole()
	{
		foreach($this->getAllowedRoles() as $role){
			if($this->user->getType() == $role)
				return;
		}
		$this->localRedirect("access-denied");
	}
	
	public function onCreate()
	{
		$this->assertLogin();
		$this->assertRole();
	}
}