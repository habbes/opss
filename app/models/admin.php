<?php

/**
 * Admin Role
 * @author Habbes
 *
 */
class Admin extends UserRole
{
	protected static $type = UserType::ADMIN;
	
	public function hasResidence()
	{
		return false;
	}
	
	public function hasNationality()
	{
		return false;
	}
	
	public function hasAddress()
	{
		return false;
	}
	
	public function hasGender()
	{
		return false;
	}
	
	public function hasAccessToPaper($paper)
	{
		return true;
	}
	
	public function canViewPaperCover()
	{
		return true;
	}
	
	public function canViewPaperAuthor()
	{
		return true;
	}
	
}