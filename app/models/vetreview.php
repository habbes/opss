<?php

/**
 * represents a review made by an admin during the vetting process
 * @author Habbes
 *
 */
class VetReview extends DBModel
{
	protected $paper_id;
	protected $admin_id;
	protected $status;
	protected $verdict;
	protected $date_initiated;
	protected $date_submitted;
	protected $comments;
	
	private $_admin;
	private $_paper;
	
	//status constants
	const STATUS_ONGOING = "ongoing";
	const STATUS_COMPLETED = "completed";
	
	//verdict constants
	const VERDICT_ACCEPTED = "accepted";
	const VERDICT_REJECTED = "rejected";
	
	
	
	/**
	 * 
	 * @param Paper $paper
	 * @return VetReview
	 */
	public static function create($paper)
	{
		$vr = new static();
		$vr->_paper = $paper;
		$vr->paper_id = $paper->getId();
		$vr->date_initiated = Utils::dbDateFormat(time());
		$vr->status = static::STATUS_ONGOING;
		
		return $vr;
	
	}
	
	/**
	 * 
	 * @return Paper
	 */
	public function getPaper()
	{
		if(!$this->_paper)
			$this->_paper = Paper::findById($this->paper_id);
		return $this->_paper;
	}
	
	/**
	 * 
	 * @return User
	 */
	public function getAdmin()
	{
		if(!$this->_admin)
			$this->_admin = User::findById($this->admin_id);
		return $this->_admin;
	}
	
	/**
	 * 
	 * @param User $admin
	 */
	public function setAdmin($admin)
	{
		$this->_admin = $admin;
		$this->admin_id = $admin->getId();
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDateInitiated()
	{
		return strtotime($this->date_initiated);
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDateSubmitted()
	{
		return strtotime($this->date_submitted);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getComments()
	{
		return $this->comments;
	}
	
	/**
	 * 
	 * @param string $comments
	 */
	public function setComments($comments)
	{
		$this->comments = $comments;
	}
	
	/**
	 * @return string
	 */
	public function getVerdict()
	{
		return $this->verdict();
	}
	
	/**
	 * 
	 * @param Admin $admin
	 * @param string $verdict one of the VERDICT_* constants
	 * @param string $comments
	 */
	public function submit($admin, $verdict, $comments = "")
	{
		$this->setAdmin($admin);
		if($comments)
			$this->comments = $comments;
		$this->verdict = $verdict;
		$this->status = self::STATUS_COMPLETED;
		$this->date_submitted = Utils::dbDateFormat(time());
		
		$errors = [];
		
		if(!$this->comments && $this->verdict == self::VERDICT_REJECTED){
			$errors[] = OperationError::VET_COMMENTS_EMPTY;
		}
		
		if(!in_array($verdict, [self::VERDICT_ACCEPTED, self::VERDICT_REJECTED])){
			$errors[] = OperationError::VET_INVALID_VERDICT;
		}
		
		if($errors){
			throw new OperationException($errors);
		}
		
		switch($verdict){
			case self::VERDICT_REJECTED:
				$this->getPaper()->setEditable(true);
				$this->getPaper()->setStatus(Paper::STATUS_VETTING_REVISION);
				break;
			case self::VERDICT_ACCEPTED:
				$this->getPaper()->setEditable(false);
				$this->getPaper()->setStatus(Paper::STATUS_PENDING);
				$this->getPaper()->addNextAction(Paper::ACTION_EXTERNAL_REVIEW);
				break;
		}
		
		$this->save();
		$this->getPaper()->save();
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return array(VetReview)
	 */
	public static function findByPaper($paper)
	{
		return static::findAllByField("paper_id", $paper->getId());
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return VetReview
	 */
	public static function findCurrentByPaper($paper)
	{
		return static::findOne("paper_id=? AND status=?", [$paper->getId(), self::STATUS_ONGOING]);
	}
}