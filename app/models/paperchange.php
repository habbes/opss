<?php

/**
 * class for storing changes made on papers
 * @author Habbes
 *
 */
class PaperChange extends DBModel
{
	
	protected $paper_id;
	protected $action;
	protected $date;
	/**
	 * json encoded string of args
	 * @var string
	 */
	protected $args;
	protected $revision;
	
	private $_paper;
	
	/**
	 * @var JsonObject
	 */
	private $_args;
	
	//actions
	const ACTION_SUBMITTED = "submitted";
	const ACTION_VETTED = "vetted";
	const ACTION_TITLE_CHANGED = "titleChanged";
	const ACTION_LANGUAGE_CHANGED = "languageChanged";
	const ACTION_COUNTRY_CHANGED = "countryChanged";
	const ACTION_AUTHOR_ADDED = "authorAdded";
	const ACTION_AUTHOR_REMOVED = "authorRemoved";
	const ACTION_FILE_CHANGED = "fileChanged";
	const ACTION_COVER_CHANGED = "coverChanged";
	const ACTION_RESUBMITTED = "resubmitted";
	
	/**
	 * 
	 * @param Paper $paper
	 * @param Action $action
	 * @return PaperChange
	 */
	public static function create($paper, $action)
	{
		$c = new static();
		$c->_paper = $paper;
		$c->paper_id = $paper->getId();
		$c->action = $action;
		$c->revision = $paper->getRevision();
		$c->_args = [];
		
		return $c;
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
	 * the revision of the paper during which this change
	 * was made
	 * @return number
	 */
	public function getRevision()
	{
		return (int) $this->revision;
	}
	
	/**
	 * the action describing this change
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDate()
	{
		return strtotime($this->date);
	}
	
	/**
	 * gets args used to store metadata about the particular
	 * change
	 * @return array
	 */
	public function getArgs()
	{
		if(!$this->_args)
			$this->_args = (array) json_decode($this->args);
		return $this->_args;
	}
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	public function setArg($name, $value)
	{
		$this->_args[$name] = $value;
	}	
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getArg($name, $default = null)
	{
		return isset($this->getArgs()[$name])?
			$this->_args[$name] : $default;
	}
	
	protected function validate(&$errors)
	{
		$this->args = json_encode($this->_args);
		return true;
	}
	
	protected function onInsert(&$errors)
	{
		$this->date = Utils::dbDateFormat(time());
		return true;
	}
	
	/**
	 * creates a change event for paper's initial submission into the system
	 * @param Paper $paper
	 * @return PaperChange
	 */
	public static function createSubmitted($paper)
	{
		$pc = static::create($paper, self::ACTION_SUBMITTED);
		$pc->setArg("researcherId", $paper->getResearcher()->getId());
		$pc->setArg("title", $paper->getTitle());
		$pc->setArg("dateSubmitted", Utils::dbDateFormat($paper->getDateSubmitted()));
		$pc->setArg("country", $paper->getCountry());
		$pc->setArg("language", $paper->getLanguage());
		$pc->setArg("fileId", $paper->getFile()->getId());
		$pc->setArg("coverId", $paper->getCover()->getId());
		$authors = [];
		foreach($paper->getAuthors() as $author){
			$authors[] = ["name"=>$author->getName(), 
				"email"=>$author->getEmail()];
		}
		$pc->setArg("authors", $authors);
		return $pc;
		
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return PaperChange
	 */
	public static function createResubmitted($paper)
	{
		$pc = static::create($paper, self::ACTION_RESUBMITTED);
		$pc->setArg("title", $paper->getTitle());
		$pc->setArg("dateSubmitted", Utils::dbDateFormat($paper->getDateSubmitted()));
		$pc->setArg("country", $paper->getCountry());
		$pc->setArg("language", $paper->getLanguage());
		$pc->setArg("fileId", $paper->getFile()->getId());
		$pc->setArg("coverId", $paper->getCover()->getId());
		$authors = [];
		foreach($paper->getAuthors() as $author){
			$authors[] = ["name"=>$author->getName(),
					"email"=>$author->getEmail()];
		}
		$pc->setArg("authors", $authors);
		return $pc;
	
	}
	
	/**
	 * creates change event when paper is vetted
	 * @param Paper $paper
	 * @param VetReview $vetReview
	 * @return PaperChange
	 */
	public static function createVetted($paper, $vetReview)
	{
		$pc = static::create($paper, self::ACTION_VETTED);
		$pc->setArg("vetReviewId", $vetReview->getId());
		
		return $pc;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param string $from
	 * @param string $to
	 * @return PaperChange
	 */
	public static function createTitleChanged($paper, $from, $to)
	{
		$pc = static::create($paper, self::ACTION_TITLE_CHANGED);
		$pc->setArg("from", $from);
		$pc->setArg("to", $to);		
		return $pc;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param string $from
	 * @param string $to
	 * @return PaperChange
	 */
	public static function createLanguageChanged($paper, $from, $to)
	{
		$pc = static::create($paper, self::ACTION_LANGUAGE_CHANGED);
		$pc->setArg("from", $from);
		$pc->setArg("to", $to);
		
		return $pc;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param string $from
	 * @param string $to
	 * @return PaperChange
	 */
	public static function createCountryChanged($paper, $from, $to)
	{
		$pc = static::create($paper, self::ACTION_COUNTRY_CHANGED);
		$pc->setArg("from", $from);
		$pc->setArg("to", $to);
		return $pc;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param File $from
	 * @param File $to
	 * @return PaperChange
	 */
	public static function createFileChanged($paper, $from, $to)
	{
		$pc = static::create($paper, self::ACTION_FILE_CHANGED);
		$pc->setArg("fromId", $from->getId());
		$pc->setArg("toId", $to->getId());
		return $pc;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param File $from
	 * @param File $to
	 * @return PaperChange
	 */
	public static function createCoverChanged($paper, $from, $to)
	{
		$pc = static::create($paper, self::ACTION_COVER_CHANGED);
		$pc->setArg("fromId", $from->getId());
		$pc->setArg("toId", $to->getId());
		return $pc;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param string $name
	 * @param string $email
	 * @param string $reasons
	 * @return PaperChange
	 */
	public static function createAuthorAdded($paper, $name, $email, $reasons)
	{
		$pc = static::create($paper, self::ACTION_AUTHOR_ADDED);
		$pc->setArg("name", $name);
		$pc->setArg("email", $email);
		$pc->setArg("reasons", $reasons);
		return $pc;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return array(PaperChange)
	 */
	public static function findByPaper($paper)
	{
		return static::findAllByField("paper_id", $paper->getId());
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param number $id
	 * @return PaperChange
	 */
	public static function findByPaperAndId($paper, $id)
	{
		return static::findOne("paper_id=? AND id=?",[
				$paper->getId(), $id
		]);
	}
	
	
}