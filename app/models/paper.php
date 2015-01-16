<?php

/**
 * represents a submitted paper
 * @author Habbes
 *
 */
class Paper extends DBModel
{
	protected $identifier;
	protected $revision;
	protected $researcher_id;
	protected $title;
	protected $date_submitted;
	protected $country;
	protected $language;
	protected $file_id;
	protected $cover_id;
	protected $status;
	protected $level;
	protected $editable;
	protected $recallable;
	protected $end_recallable_date;
	
	private $_researcher;
	private $_file;
	private $_cover;
	private $_authors = [];
	private $_authorsNames = [];
	private $_groups;
	
	const DIR = "papers";
	const GRACE_PERIOD = 2; //days
	
	//status
	const PENDING = 1;
	const VETTING = 2;
	const REVIEW = 3;
	const REWRITE_MAJ = 4;
	const REWRITE_MIN = 5;
	const ACCEPTED = 4;
	
	
	/**
	 * 
	 * @param User $researcher
	 * @param int $grace_period
	 * @return Paper
	 */
	public static function create($researcher, $grace_period = null)
	{
		$paper = new static();
		$paper->_researcher = $researcher;
		$paper->researcher_id = $researcher->getId();
		$paper->status = Paper::PENDING;
		$paper->editable = true;
		$paper->recallable = true;
		$paper->level = PaperLevel::PROPOSAL;
		$paper->revision = 1;
		if(!$grace_period) $grace_period = self::GRACE_PERIOD;
		$paper->end_recallable_date = time() + $grace_period * 84600;
		
		return $paper;
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
	 * 
	 * @return number
	 */
	public function getRevision()
	{
		return (int) $this->revision;
	}
	
	/**
	 * 
	 * @param number $rev
	 */
	public function setRevision($rev)
	{
		$this->revision = $rev;
	}
	
	/**
	 * 
	 */
	public function incrementRevision()
	{
		$this->setRevision($this->getRevision + 1);
	}

	/**
	 * 
	 * @return boolean
	 */
	public function isEditable()
	{
		return (boolean) $this->editable();
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isRecallable()
	{
		return (boolean) $this->recallable();
	}
	
	/**
	 * store's a file in this paper's directory, to be used as
	 * main document or cover
	 * @param string $filename original name of the file
	 * @param string $sourcePath where the file is being copied/moved from
	 * @param boolean $fromUpload whether the file comes from a user upload
	 */
	private function createFile($filename, $sourcePath, $fromUpload = true)
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
	public function setFile($filename, $sourcePath, $fromUpload = true)
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
	public function setCover($filename, $sourcePath, $fromUpload = true)
	{
		$file = $this->createFile($filename, $sourcePath, $fromUpload);
		$this->cover_id = $file->getId();
		$this->_cover = $file;
	}
	
	/**
	 * fetches co-authors from database
	 */
	private function fetchAuthors()
	{
		if(!$this->_authors){
			$this->_authors = PaperAuthor::findByPaper($this);
			$this->_authorsNames = array();
			foreach($this->_authors as $author){
				$this->_authorsNames[] = $author->getName();
			}
		}
	}
	
	/**
	 * 
	 * @return array(PaperAuthor)
	 */
	public function getAuthors()
	{
		$this->fetchAuthors();
		return $this->_authors;
	}
	
	/**
	 * 
	 * @return array(string);
	 */
	public function getAuthorsNames()
	{
		$this->fetchAuthors();
		return $this->_authorsNames;
	}
	
	/**
	 * 
	 * @param string $name
	 * @param string $email
	 * @return PaperAuthor
	 */
	public function addAuthor($name, $email)
	{
		$author = CoAuthor::create($name, $email);
		$author->save();
		$pa = PaperAuthor::create($this, $author);
		$pa->save();
		array_push($this->_authors, $author);
		array_push($this->_authorsNames, $author->getName());
		return $pa;
	}
	
	/**
	 * remove the co-author with the given email
	 * @param string $email
	 * @return boolean
	 */
	public function removeAuthor($email)
	{
		$this->fetchAuthors();
		$pAuthor = null;
		$i = 0;
		foreach($this->_authors as $a){
			$i++;
			if($a->getEmail() == $email){
				$pAuthor = $a;
				break;
			}
		}
		if(!$pAuthor){
			//TODO: throw exception instead
			return false;
		}
		
		array_splice($this->authors_names, $i, 1);
		array_splice($this->authors, $i, 1);
		
		$pAuthor->delete();
		
		return true;
	}
	
	protected function onInsert(&$errors)
	{
		$this->date_submitted = Utils::dbDateFormat(time());
		return true;
	}
	
	protected function validate(&$errors)
	{
		if(!$this->title)
			$errors[] = OperationError::PAPER_COUNTRY_EMPTY;
		if(!$this->language)
			$errors[] = OperationError::PAPER_LANGUAGE_EMPTY;
		if(!$this->country)
			$errors[] = OperationError::PAPER_COUNTRY_EMPTY;
		
		return true;
	}
	
	protected function afterInsert()
	{
		$date = getdate($this->getDateSubmitted());
		$identifier = sprintf("%04d%02d%d",$date['year'],$date['mon'],$this->getId());
		$this->identifier = $identifier;
		$this->save();
	}
	
	/**
	 * send paper for vetting
	 */
	public function sendForVetting()
	{
		$this->status = self::VETTING;
		$this->editable = false;
		$this->recallable = false;
		$this->save();
	}
	
	/**
	 * 
	 * @param User $researcher
	 * @return array(Paper)
	 */
	public static function findByResearcher($researcher)
	{
		return static::findAllByField("researcher_id", $researcher->getId());
	}
	
	/**
	 * 
	 * @param string $identifier
	 * @return Paper
	 */
	public static function findByIdentifier($identifier)
	{
		return static::findOneByField("identifier", $identifier);
	}
	
}