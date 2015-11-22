<?php

/**
 * Reviewer Role
 * @author Habbes
 *
 */
class Reviewer extends UserRole
{
	protected static $type = UserType::REVIEWER;
	
	public function getPapers()
	{
		return Paper::findAll("id IN (SELECT paper_id FROM reviews WHERE reviewer_id=? AND status=?)", 
				[ $this->user->getId(), Review::STATUS_ONGOING]);
	}
	
	/**
	 * the number of papers this reviewer is reviewing
	 * @return number
	 */
	public function countPapers()
	{
		//TODO find a way to refactor the count, the query is too redundant
		return Paper::count("id IN (SELECT paper_id FROM reviews WHERE reviewer_id=? AND status=?)", 
				[ $this->user->getId(), Review::STATUS_ONGOING]);
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
		return $this->user->is($paper->getCurrentReviewer());
	}
	public function canViewPaperCover()
	{
		return false;
	}
	public function canViewPaperAuthor()
	{
		return false;
	}
	public function canEditPaper()
	{
		return false;
	}
	public function canVetPaper()
	{
		return false;
	}
	public function canReviewPaper()
	{
		return true;
	}
	public function canViewReviewCommentsToAuthor($review)
	{
		return $this->is($review->getReviewer());
	}
	public function canViewReviewCommentsToAdmin($review)
	{
		return true;
	}
	public function canViewReviewAdminComments($review)
	{
		return true;
	}
}