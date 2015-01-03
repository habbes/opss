<?php

class Paper extends DBModel
{
	protected $researcher_id;
	protected $title;
	protected $date_submitted;
	protected $country;
	protected $language;
	protected $file_id;
	protected $cover_id;
	protected $status;
	protected $level;
	protected $recallable;
	protected $end_recallable_date;
	
	private $_researcher;
	private $_file;
	private $_cover;
	private $_authors;
	private $_groups;
	
	const DIR = "papers";
	const GRACE_PERIOD = 2;
	
	public static function create($researcher, $grace_period = null)
	{
		
	}
	
	/**
	 * 
	 * @return User
	 */
	public function getResearcher()
	{
		if(!$this->_researcher)
			$this->_researcher = User::findById($this->researcher_id);
		return $this->_researcher;
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
	 * @return number
	 */
	public function getStatus()
	{
		return (int) $this->status;
	}
	
	/**
	 * store's a file in this paper's directory, to be used as
	 * main document or cover
	 * @param string $filename original name of the file
	 * @param string $sourcePath where the file is being copied/moved from
	 * @param boolean $fromUpload whether the file comes from a user upload
	 */
	private function createFile($filename, $sourcePath, $fromUpload)
	{
		$ds = DIRECTORY_SEPARATOR;
		$dir = self::DIR.$ds.$this->getResearcher()->getUsername();
		$f = File::create($filename, $dir, $sourcePath, $fromUpload);
		return $f->save();
	}
	
	/**
	 * 
	 * @return File
	 */
	public function getFile()
	{
		if(!$this->_file)
			$this->_file = File::findById($this->file_id);
		return $this->_file;
	}
	
	/**
	 * set the main document file of the paper
	 * @param string $filename
	 * @param string $sourcePath
	 * @param boolean $fromUpload
	 */
	public function setFile($filename, $sourcePath, $fromUpload)
	{
		$file = $this->createFile($filename, $sourcePath, $fromUpload);
		$this->file_id = $file->getId();
		$this->_file = $file;
	}
	
	/**
	 * 
	 * @return File
	 */
	public function getCover()
	{
		if(!$this->_cover)
			$this->_cover = File::findById($this->cover_id);
		return $this->_cover;
	}
	
	/**
	 * 
	 * @param string $filename
	 * @param string $sourcePath
	 * @param boolean $fromUpload
	 */
	public function setCover($filename, $sourcePath, $fromUpload)
	{
		$file = $this->createFile($filename, $sourcePath, $fromUpload);
		$this->file_id = $file->getId();
		$this->_file = $file;
	}
	
	
}