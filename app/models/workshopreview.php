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
	
	//verdict
	const VERDICT_ACCEPTED = "accepted";
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
}