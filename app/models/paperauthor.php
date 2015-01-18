<?php

/**
 * represents a co-author for a specific paper (association between
 * Paper and CoAuthor)
 * @author Habbes
 *
 */
class PaperAuthor extends DBModel
{
	
	protected $paper_id;
	protected $author_id;
	protected $date_added;
	
	private $_paper;
	private $_author;
	
	/**
	 * 
	 * @param Paper $paper
	 * @param CoAuthor $author
	 * @return PaperAuthor
	 */
	public static function create($paper, $author)
	{
		$pa = new static();
		$pa->_paper = $paper;
		$pa->paper_id = $paper->getId();
		$pa->_author = $author;
		$pa->author_id = $author->getId();
		return $pa;
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
	 * @return Author
	 */
	public function getAuthor()
	{
		if(!$this->_author)
			$this->_author = CoAuthor::findById($this->author_id);
		return $this->_author;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->getAuthor()->getName();
	}
	
	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->getAuthor()->getEmail();
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDateAdded()
	{
		return strtotime($this->date_added);
	}
	
	protected function onInsert(&$errors)
	{
		$this->date_added = Utils::dbDateFormat(time());
		return true;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return array(PaperAuthor)
	 */
	public static function findByPaper($paper)
	{
		return static::findAllByField("paper_id", $paper->getId());
	}
	
	
}