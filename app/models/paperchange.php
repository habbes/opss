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
			$this->_args = json_decode($this->args);
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
	 * @return array(PaperChange)
	 */
	public static function findByPaper($paper)
	{
		return static::findAllByField("paper_id", $paper->getId());
	}
	
	
}