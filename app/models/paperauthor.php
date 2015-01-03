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
	
	private $_paper;
	private $_author;
	
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
	 * 
	 * @param Paper $paper
	 * @return array(PaperAuthor)
	 */
	public static function findByPaper($paper)
	{
		return static::findAllByField("paper_id", $paper->getId());
	}
	
}