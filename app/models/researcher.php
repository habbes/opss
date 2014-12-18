<?php

/**
 * Researcher Role
 * @author Habbes
 *
 */
class Researcher extends UserRole
{
	protected $type = UserType::RESEARCHER;
	
	public function hasResidence()
	{
		return true;
	}
	public function hasNationality()
	{
		return true;
	}
	public function hasAddress()
	{
		return true;
	}
	public function hasGender()
	{
		return true;
	}
}