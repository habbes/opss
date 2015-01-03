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
	private $_file;
	/**
	 * @var JsonObject
	 */
	private $_args;
	
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
	
	public function validate(&$errors)
	{
		$this->args = json_encode($this->_args);
	}
	
	public function onInsert(&$errors)
	{
		$this->date = Utils::dbDateFormat(time());
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