<?php

/**
 * Admin Role
 * @author Habbes
 *
 */
class Admin extends UserRole
{
	protected static $type = UserType::ADMIN;
	
	public function getPapers()
	{
		return Paper::findAll();
	}
	
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
	
	public function hasAreaOfSpecialization()
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
	
	public function canEditPaper()
	{
		return true;
	}
	
	public function canVetPaper()
	{
		return true;
	}
	
	public function canReviewPaper()
	{
		return false;
	}
	
	public function canViewReview($review)
	{
		return true;
	}
	
}