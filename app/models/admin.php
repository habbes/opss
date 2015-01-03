<?php

/**
 * Admin Role
 * @author Habbes
 *
 */
class Admin extends UserRole
{
	protected $type = UserType::ADMIN;
	
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
}