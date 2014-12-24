<?php

/**
 * base class for handlers that restrict access only to admins
 * @author Habbes
 *
 */
class AdminHandler extends RoleHandler
{
	protected function getAllowedRoles()
	{
		return [UserType::ADMIN];
	}
}