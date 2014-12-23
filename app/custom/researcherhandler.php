<?php

/**
 * base class for handlers that restrict access only to researchers
 * @author Habbes
 *
 */
class ResearcherHandler extends RoleHandler
{
	protected function getAllowedRoles()
	{
		return [UserType::RESEARCHER];
	}
}