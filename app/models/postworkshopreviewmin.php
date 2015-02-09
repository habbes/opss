<?php

class PostWorkshopReviewMin extends DBModel
{
	protected $paper_id;
	protected $admin_id;
	protected $status;
	protected $verdict;
	protected $comments;
	protected $file_id;
	protected $date_initiated;
	protected $date_submitted;
	
	private $_admin;
	private $_paper;
	private $_file;
	
	const DIR = "post_workshop_reviews";
	
	//status
	const STATUS_ONGOING = "ongoing";
	const STATUS_COMPLETED = "completed";
	
	//verdict
	const VERDICT_APPROVED = "approved";
	const VERDICT_REJECTED = "revisionMin";
	
	/**
	 * 
	 * @param Paper $paper
	 * @param User $admin
	 * @return PostWorkshopReviewMin
	 */
	public static function create($paper, $admin)
	{
		$p = new static();
		$p->paper_id = $paper->getId();
		$p->_paper = $paper;
		$p->admin_id = $admin->getId();
		$p->_admin = $admin;
		$p->status = self::STATUS_ONGOING;
		$p->date_initiated = Utils::dbDateFormat(time());
		
		return $p;
	}
	
	public function getPaper()
	{
		if(!$this->_paper)
			$this->_paper = Paper::findById($this->paper_id);
		return $this->_paper;
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
	
	public function submit($verdict)
	{
		$this->verdict = $verdict;
		$this->date_submitted = Utils::dbDateFormat(time());
		$this->status = self::STATUS_COMPLETED;
	}
	
	public static function getVerdicts()
	{
		return [self::VERDICT_APPROVED, self::VERDICT_REJECTED];
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
					
			case self::VERDICT_REJECTED:
				return "Rejected";

		}
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return PostWorkshopReviewMin
	 */
	public static function findCurrentByPaper($paper)
	{
		return static::findOne("paper_id=? AND status=?",[
				$paper->getId(), self::STATUS_COMPLETED
		]);
	}
}