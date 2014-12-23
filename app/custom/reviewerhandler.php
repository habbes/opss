<?php

/**
 * base class for handlers that restrict access only to reviewers
 * @author Habbes
 *
 */
class ReviewerHandler extends RoleHandler
{
	protected function getAllowedRoles()
	{
		return [UserType::REVIEWER];
	}
}