<?php

/**
 * Researcher Role
 * @author Habbes
 *
 */
class Researcher extends UserRole
{
	protected static $type = UserType::RESEARCHER;
	
	
	public function getPapers()
	{
		return Paper::findByResearcher($this->user);	
	}	
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
	public function hasAreaOfSpecialization()
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
	public function canEditPaper()
	{
		return true;
	}
	public function canVetPaper()
	{
		return false;
	}
	public function canReviewPaper()
	{
		return false;
	}
	public function canViewReviewCommentsToAuthor($review)
	{
		return $this->user->is($review->getPaper()->getResearcher()) &&
			$review->isPosted();
	}
	public function canViewReviewCommentsToAdmin($review)
	{
		return false;
	}
	public function canViewReviewAdminComments($review)
	{
		return $this->user->is($review->getPaper()->getResearcher());
	}
}