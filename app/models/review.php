<?php


class Review extends DBModel
{
	
	protected $paper_id;
	protected $reviewer_id;
	protected $admin_id;
	protected $status;
	protected $recommendation;
	protected $comments;
	protected $researcher_comments;
	protected $file_id;
	protected $researcher_file_id;
	protected $date_submitted;
	protected $permanent = true;
	protected $due_date;
	protected $posted;
	protected $date_posted;
	protected $date_initiated;
	
	private $_paper;
	private $_reviewer;
	private $_file;
	private $_researcherFile;
	
	const DIR = "reviews";
	
	//status
	const STATUS_ONGOING = 1;
	const STATUS_COMPLETED = 2;
	const STATUS_OVERDUE = 3;
	
	//recommendations
	const VERDICT_APPROVED = "approved";
	const VERDICT_REVISION_MIN = "revisionMaj";
	const VERDICT_REVISION_MAJ = "revisionMin";
	
	/**
	 * 
	 * @param Paper $paper
	 * @param Reviewer $reviewer
	 * @param Admin $admin
	 * @return Review
	 */
	public static function create($paper, $reviewer, $admin)
	{
		$r = new static();
		$r->_paper = $paper;
		$r->paper_id = $paper->getId();
		$r->_reviewer = $reviewer;
		$r->reviewer_id = $reviewer->getId();
		$r->_admin = $admin;
		$r->admin_id = $admin->getId();
		$r->status = self::STATUS_ONGOING;
		$r->data_initiated = Utils::dbDateFormat(time());
		$r->posted = false;
		
		return $r;
	}
	
	/**
	 * the reviewer conducting the review
	 * @return Reviewer
	 */
	public function getReviewer()
	{
		if(!$this->_reviewer)
			$this->_reviewer = User::findById($this->reviewer_id);
		return $this->_reviewer;
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
	 * the admin who authorized the review
	 * @return User
	 */
	public function getAdmin()
	{
		if(!$this->_admin)
			$this->_admin = User::findById($this->admin_id);
		return $this->_admin;
	}
	
	/**
	 * a file containing elaborate comments
	 * @return File
	 */
	public function getFile()
	{
		if(!$this->_file)
			$this->_file = File::findById($this->file_id);
		return $this->_file;
	}
	
	public function setFile($file)
	{
		$this->_file = $file;
		$this->file_id = $file->getId();
	}
	
	/**
	 * comments file that the researcher is allowed to view
	 * @return DBModel
	 */
	public function getResearcherFile()
	{
		if(!$this->_researcherFile)
			$this->_researcherFile = File::findById($this->file_id);
		return $this->_researcherFile;
	}
	
	public function setResearcherFile($file)
	{
		$this->_researcherFile = $file;
		$this->researcher_file_id = $file->getId();
	}
	
	public function getDueDate()
	{
		return strtotime($this->due_date);
	}
	
	public function setDueDate($date)
	{
		$this->due_date = Utils::dbDateFormat($date);
	}
	
	public function getDateInitiated()
	{
		return strtotime($this->date_initiated);
	}
	
	public function isPosted()
	{
		return (boolean) $this->posted;
	}
	
	public function getDatePosted()
	{
		return strtotime($this->date_posted);
	}
	
	public function setDatePosted($date)
	{
		$this->date_posted = Utils::dbDateFormat($date);
	}
	
	public function isPermanent()
	{
		return (boolean) $this->permanent;
	}
	
	public function getStatus()
	{
		return (int) $this->status;
	}
	
	public function isOngoing()
	{
		return $this->getStatus() == self::ONGOING;
	}
	
	public function isCompleted()
	{
		return $this->getStatus() == self::COMPLETED;
	}
	
	public function isOverdue()
	{
		return (!$this->isPermanent() && time() > $this->getDueDate());
	}
	
	public function submit($recommendation)
	{
		$this->status = Review::STATUS_COMPLETED;
		$this->recommendation = $recommendation;
		$this->date_submitted = Utils::dbDateFormat(time());
		$this->save();
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return array(Review)
	 */
	public static function findByPaper($paper)
	{
		return static::findAllByField("paper_id", $paper->getId());
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return Review
	 */
	public static function findCurrentByPaper($paper)
	{
		return static::findOne("status=? AND paper_id=?",
				[Review::STATUS_ONGOING, $paper->getId()]);
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param Reviewer $reviewer
	 * @return Review
	 */
	public static function findCurrentByPaperAndReviewer($paper, $reviewer){
		return static::findOne("status=? AND paper_id=? AND reviewer_id=?",
				[Review::STATUS_ONGOING, $paper->getId(), $paper->getReviewer()]);
	}
	
	
}