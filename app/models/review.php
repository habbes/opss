<?php


class Review extends DBModel
{
	
	protected $paper_id;
	protected $reviewer_id;
	protected $admin_id;
	protected $status;
	protected $recommendation;
	protected $comments_to_admin;
	protected $comments_to_author;
	protected $file_to_admin_id;
	protected $file_to_author_id;
	protected $admin_comments;
	protected $admin_file_id;
	protected $admin_verdict;
	protected $date_submitted;
	protected $permanent = true;
	protected $due_date;
	protected $posted;
	protected $date_posted;
	protected $date_initiated;
	
	private $_paper;
	private $_reviewer;
	private $_fileToAdmin;
	private $_fileToAuthor;
	private $_adminFile;
	
	const DIR = "reviews";
	
	//status
	const STATUS_ONGOING = 1;
	const STATUS_COMPLETED = 2;
	const STATUS_OVERDUE = 3;
	
	//recommendations
	const VERDICT_APPROVED = "approved";
	const VERDICT_REVISION_MIN = "revisionMin";
	const VERDICT_REVISION_MAJ = "revisionMaj";
	const VERDICT_REJECTED = "rejected";
	
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
		$r->date_initiated = Utils::dbDateFormat(time());
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
	 * 
	 * @return string
	 */
	public function getCommentsToAdmin()
	{
		return $this->comments_to_admin;
	}
	
	/**
	 * 
	 * @param string $comments
	 */
	public function setCommentsToAdmin($comments)
	{
		$this->comments_to_admin = $comments;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getCommentsToAuthor()
	{
		return $this->comments_to_author;
	}
	
	/**
	 * 
	 * @param string $comments
	 */
	public function setCommentsToAuthor($comments)
	{
		$this->comments_to_author = $comments;
	}
	
	/**
	 * stores a file in this paper's review directories
	 * @param string $filename
	 * @param string $sourcePath
	 * @param boolean $fromUpload
	 * @return File
	 */
	private function createFile($filename, $sourcePath, $fromUpload = true)
	{
		$ds = DIRECTORY_SEPARATOR;
		$dir = self::DIR.$ds.$this->getPaper()->getIdentifier();
		$f = File::create($filename, $dir, $sourcePath, $fromUpload);
		return $f->save();
	}
	
	/**
	 * a file containing elaborate comments
	 * @return File
	 */
	public function getFileToAdmin()
	{
		if(!$this->_fileToAdmin)
			$this->_fileToAdmin = File::findById($this->file_to_admin_id);
		return $this->_fileToAdmin;
	}
	
	/**
	 * checks whether this review has general file containing elaborate comments
	 * @return boolean
	 */
	public function hasFileToAdmin()
	{
		return $this->file_to_admin_id? true : false;
	}
	
	/**
	 * 
	 * @param string $filename
	 * @param string $sourcePath
	 * @param boolean $fromUpload
	 */
	public function setFileToAdmin($filename, $sourcePath, $fromUpload = true)
	{
		$file = $this->createFile($filename, $sourcePath, $fromUpload);
		$this->file_to_admin_id = $file->getId();
		$this->_fileToAdmin = $file;
	}
	
	/**
	 * comments file that the researcher is allowed to view
	 * @return File
	 */
	public function getFileToAuthor()
	{
		if(!$this->_fileToAuthor)
			$this->_fileToAuthor = File::findById($this->file_to_author_id);
		return $this->_fileToAuthor;
	}
	
	/**
	 * checks whether this review has file containing elaborate comments meant
	 * for the researcher
	 * @return boolean
	 */
	public function hasFileToAuthor()
	{
		return $this->file_to_author_id? true : false;
	}
	
	/**
	 * 
	 * @param string $filename
	 * @param string $sourcePath
	 * @param boolean $fromUpload
	 */
	public function setFileToAuthor($filename, $sourcePath, $fromUpload = true)
	{
		$file = $this->createFile($filename, $sourcePath, $fromUpload);
		$this->file_to_author_id = $file->getId();
		$this->_fileToAuthor = $file;
	}
	
	/**
	 * comments file written by admin
	 * @return File
	 */
	public function getAdminFile()
	{
		if(!$this->_adminFile)
			$this->_adminFile = File::findById($this->admin_file_id);
		return $this->_adminFile;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function hasAdminFile()
	{
		return $this->admin_file_id? true : false;
	}
	
	/**
	 * 
	 * @param string $comments
	 */
	public function setAdminComment($comments)
	{
		$this->admin_comments = $comments;
	}
	
	/**
	 * set comments file written by admin
	 * @param string $filename
	 * @param string $sourcePath
	 * @param boolean $fromUpload
	 */
	public function setAdminFile($filename, $sourcePath, $fromUpload = true)
	{
		$file = $this->createFile($filename, $sourcePath, $fromUpload);
		$this->admin_file_id = $file->getId();
		$this->_adminFile = $file;
	}
	
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDueDate()
	{
		return strtotime($this->due_date);
	}
	
	/**
	 * 
	 * @param number $date timestamp
	 */
	public function setDueDate($date)
	{
		$this->due_date = Utils::dbDateFormat($date);
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
	 * @return boolean
	 */
	public function isPosted()
	{
		return (boolean) $this->posted;
	}
	
	public function setPosted($posted)
	{
		$this->posted = $posted;
		$this->date_posted = Utils::dbDateFormat(time());
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDatePosted()
	{
		return strtotime($this->date_posted);
	}
	
	/**
	 * 
	 * @param number $date timestamp
	 */
	public function setDatePosted($date)
	{
		$this->date_posted = Utils::dbDateFormat($date);
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
	 * @return boolean
	 */
	public function isPermanent()
	{
		return (boolean) $this->permanent;
	}
	
	/**
	 * 
	 * @return number values are STATUS_* constants
	 */
	public function getStatus()
	{
		return (int) $this->status;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isOngoing()
	{
		return $this->getStatus() == self::STATUS_ONGOING;
	}
	
	public function isCompleted()
	{
		return $this->getStatus() == self::STATUS_COMPLETED;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isOverdue()
	{
		return (!$this->isPermanent() && time() > $this->getDueDate());
	}
	
	/**
	 * submit reviewer recommendation and comments
	 * @param int $recommendation value from VERDICT_* constants
	 */
	public function submit($recommendation)
	{
		$this->status = Review::STATUS_COMPLETED;
		$this->recommendation = $recommendation;
		$this->date_submitted = Utils::dbDateFormat(time());
	}
	
	/**
	 * 
	 * @param string $verdict
	 */
	public function submitAdminReview($verdict)
	{
		$this->admin_verdict = $verdict;
	}
	
	/**
	 * 
	 * @return array(string)
	 */
	public static function getVerdicts()
	{
		return [self::VERDICT_APPROVED, self::VERDICT_REVISION_MIN,
				self::VERDICT_REVISION_MAJ];
	}
	
	public static function getAdminVerdicts()
	{
		return [self::VERDICT_APPROVED, self::VERDICT_REVISION_MIN,
				self::VERDICT_REVISION_MAJ, self::VERDICT_REJECTED];
	}
	
	/**
	 * 
	 * @param string $verdict
	 * @return string
	 */
	public static function getVerdictString($verdict)
	{
		switch($verdict){
			case self::VERDICT_APPROVED:
				return "Approved";
			
			case self::VERDICT_REVISION_MAJ:
				return "Major Revision";
			
			case self::VERDICT_REVISION_MIN:
				return "Minor Revision";
			
			case self::VERDICT_REJECTED:
				return "Rejected";
		}
	}
	
	public static function getStatusString($status)
	{
		switch($status){
			case self::STATUS_COMPLETED:
				return "Completed";
			case self::STATUS_ONGOING:
				return "Ongoing";
			case self::STATUS_OVERDUE:
				return "Overdue";
		}
	}
	
	/**
	 * 
	 * @param string $verdict VERDICT_* constants
	 * @return boolean
	 */
	public static function isValidVerdict($verdict)
	{
		return in_array($verdict, self::getVerdicts());
	}
	
	/**
	 * 
	 * @param string $verdict
	 * @return boolean
	 */
	public static function isValidAdminVerdict($verdict)
	{
		return in_array($verdict, self::getAdminVerdicts());
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
	 * @param User $reviewer
	 * @return array(Review)
	 */
	public static function findByReviewer($reviewer)
	{
		return static::findAllByField("reviewer_id", $reviewer->getId());
	}
	
	/**
	 * 
	 * @param number $id
	 * @param Paper $paper
	 * @return Review
	 */
	public static function findByIdAndPaper($id, $paper)
	{
		return static::findOne("id=? AND paper_id=?",[
				$id, $paper->getId()
		]);
	}
	
	/**
	 * @param Paper $paper
	 * @return array(Review)
	 */
	public static function findCompletedByPaper($paper)
	{
		return static::findAll("status=? AND paper_id=?",[
				self::STATUS_COMPLETED, $paper->getId()
		]);
	}
	
	/**
	 * 
	 * @param User $reviewer
	 * @return array(Review)
	 */
	public static function findCompletedByReviewer($reviewer)
	{
		return static::findAll("status=? AND reviewer_id=?",[
				self::STATUS_COMPLETED, $reviewer->getId()
		]);
	}
	
	
	
	/**
	 * 
	 * @param number $id
	 * @param Paper $paper
	 * @return DBModel
	 */
	public static function findCompletedByIdAndPaper($id, $paper)
	{
		return static::findOne("id=? AND status=? AND paper_id=?",[
				$id, Review::STATUS_COMPLETED, $paper->getId()
		]);
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
				[Review::STATUS_ONGOING, $paper->getId(), $reviewer->getId()]);
	}
	
	/**
	 *
	 * @param Paper $paper
	 * @param Reviewer $reviewer
	 * @return Review
	 */
	public static function findCurrentByReviewer($reviewer){
		return static::findOne("status=? AND reviewer_id=?",
				[Review::STATUS_ONGOING, $reviewer->getId()]);
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return Review
	 */
	public static function findRecentlySubmittedByPaper($paper){
		return static::findOne("status=? AND paper_id=? ORDER BY date_submitted DESC LIMIT 1",[
				Review::STATUS_COMPLETED, $paper->getId()
		]);
	}
	
	
}