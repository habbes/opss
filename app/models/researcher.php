<?php

/**
 * Researcher Role
 * @author Habbes
 *
 */
class Researcher extends UserRole
{
	protected static $type = UserType::RESEARCHER;
	
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
	public function hasAccessToPaper($paper)
	{
		return $this->user->is($paper->getResearcher());
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