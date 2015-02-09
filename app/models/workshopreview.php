<?php

/**
 * review captured by admins during biannual workshop
 * @author Habbes
 *
 */
class WorkshopReview extends DBModel
{
	protected $paper_id;
	protected $workshop_id;
	protected $admin_id;
	protected $comments;
	protected $file_id;
	protected $verdict;
	protected $status;
	protected $date_initiated;
	protected $date_submitted;
	
	private $_paper;
	private $_workshop;
	private $_file;
	private $_admin;
	
	const DIR = "workshop_reviews";
	
	//verdict
	const VERDICT_APPROVED = "approved";
	const VERDICT_REJECTED = "rejected";
	const VERDICT_REVISION_MIN = "revisionMin";
	const VERDICT_REVISION_MAJ = "revisionMaj";
	
	//status
	const STATUS_ONGOING = "ongoing";
	const STATUS_COMPLETED = "completed";
	
	
	/**
	 * 
	 * @param Paper $paper
	 * @param Workshop $workshop
	 * @param User $admin
	 * @return WorkshopReview
	 */
	public static function create($paper, $workshop, $admin)
	{
		$w = new static();
		$w->_paper = $paper;
		$w->paper_id = $paper->getId();
		$w->_workshop = $workshop;
		$w->workshop_id = $workshop->getId();
		$w->_admin = $admin;
		$w->admin_id = $admin->getId();
		$w->date_initiated = Utils::dbDateFormat(time());
		$w->status = self::STATUS_ONGOING;
		
		return $w;
	}
	
	public function getPaper()
	{
		if(!$this->_paper)
			$this->_paper = Paper::findById($this->paper_id);
		return $this->_paper;
	}
	
	public function getWorkshop()
	{
		if(!$this->_workshop)
			$this->_workshop = Workshop::findById($this->workshop_id);
		return $this->_workshop;
	}
	
	public function getAdmin()
	{
		if(!$this->_admin)
			$this->_admin = User::findById($this->admin_id);
		return $this->_admin;
	}
	
	public function setComments($comments)
	{
		$this->comments = $comments;
	}
	
	public function getComments()
	{
		return $this->comments;
	}
	
	/**
	 * stores a file in this paper's workshop review directories
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
	 *
	 * @param string $filename
	 * @param string $sourcePath
	 * @param boolean $fromUpload
	 */
	public function setFile($filename, $sourcePath, $fromUpload = true)
	{
		$file = $this->createFile($filename, $sourcePath, $fromUpload);
		$this->file_id = $file->getId();
		$this->_file = $file;
	}
	
	public function getFile()
	{
		if(!$this->_file)
			$this->_file = File::findById($this->file_id);
		return $this->_file;
	}
	
	public function hasFile()
	{
		return $this->file_id? true : false;
	}
	
	public function getVerdict()
	{
		return $this->verdict;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function submit($verdict)
	{
		$this->verdict = $verdict;
		$this->date_submitted = Utils::dbDateFormat(time());
		$this->status = self::STATUS_COMPLETED;
	}
	
	public static function getVerdicts()
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
	
	/**
	 *
	 * @param string $verdict VERDICT_* constants
	 * @return boolean
	 */
	public static function isValidVerdict($verdict)
	{
		return in_array($verdict, self::getVerdicts());
	}
	
	public static function findByWorkshop($workshop)
	{
		return static::findAllByField("workshop_id", $workshop->getId());
	}
	
	public static function findByPaper($paper)
	{
		return static::findAllByField("paper_id", $paper->getId());
	}
	
	public static function findByWorkshopAndPaper($workshop, $paper)
	{
		return static::findOne("workshop_id=? AND paper_id=?",[
				$workshop->getId(), $paper->getId()
		]);
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return WorkshopReview
	 */
	public static function findCurrentByPaper($paper)
	{
		return static::findOne("paper_id=? AND status=?",[
				$paper->getId(), self::STATUS_ONGOING
		]);
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return WorkshopReview
	 */
	public static function findRecentlySubmittedByPaper($paper)
	{
		return static::findOne("paper_id=? AND status=? ORDER BY date_submitted DESC LIMIT 1",[
				$paper->getId(), self::STATUS_COMPLETED,
		]);
	}
}