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
	public function getFile()
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
		return $this->getStatus() == self::ONGOING;
	}
	
	public function isCompleted()
	{
		return $this->getStatus() == self::COMPLETED;
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