<?php

class Workshop extends DBModel
{
	protected $year;
	protected $month;
	protected $name;
	
	public static function create($year, $month)
	{
		$w = new static();
		$w->year = $year;
		$w->month = $month;
		return $w;
	}
	
	/**
	 * 
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @return int
	 */
	public function getYear()
	{
		return $this->year;
	}
	
	/**
	 * 
	 * @param int $year
	 */
	public function setYear($year)
	{
		$this->year = $year;
	}
	
	/**
	 * @return int
	 */
	public function getMonth()
	{
		return $this->month;
	}
	
	/**
	 * 
	 * @param int $month
	 */
	public function setMonth($month)
	{
		$this->month = $month;
	}
	
	/**
	 * absolute url of the workshop's start page
	 * @return string
	 */
	public function getAbsoluteUrl()
	{
		return URL_ROOT."/workshops/".$this->getStringId();
	}
	
	/**
	 * string description of this workshop
	 * @return string
	 */
	public function toString()
	{
		$time = self::getMonthString($this->month). " " . $this->getYear();
		return $this->name? $this->name." ($time)" : $time;
	}
	
	/**
	 * month-year string that uniquely identifies this workshop
	 * @return string
	 */
	public function getStringId()
	{
		return self::getMonthString($this->month). "-" . $this->getYear();
	}
	
	/**
	 * papers set for this workshop
	 * @return array(Paper)
	 */
	public function getPapers()
	{
		return paper::findByWorkshop($this);
	}
	
	public function validate(&$errors)
	{
		if(static::findByMonthAndYear($this->month, $this->year))
			$errors[] = OperationError::WORKSHOP_EXISTS;
		return true;
	}
	
	public function onInsert(&$errors)
	{
		if(!$this->month)
			$errors[] = OperationError::WORKSHOP_MONTH_EMPTY;
		if(!array_key_exists($this->month, static::getMonthStrings()))
			$errors[] = OperationError::WORKSHOP_MONTH_INVALID;
		if(!$this->year)
			$errors[] = OperationError::WORKSHOP_YEAR_EMPTY;
		
		return true;
	}
	
	/**
	 * 
	 * @return array(string)
	 */
	public static function getMonthStrings()
	{
		return [
				1 => "January",
				2 => "February",
				3 => "March",
				4 => "April",
				5 => "May",
				6 => "June",
				7 => "July",
				8 => "August",
				9 => "September",
				10 => "October",
				11 => "November",
				12 => "December",
		];
	}
	
	/**
	 * 
	 * @param int $month
	 * @return string
	 */
	public static function getMonthString($month)
	{
		return static::getMonthStrings()[$month];
	}
	
	/**
	 * 
	 * @param string $month
	 * @return int
	 */
	public static function getMonthNumber($month)
	{
		foreach(self::getMonthStrings() as $num => $string){
			if(strtolower($string) == strtolower($month))
				return $num;
		}
	}
	
	
	/**
	 * 
	 * @param int $month
	 * @param int $year
	 * @return Workshop
	 */
	public static function findByMonthAndYear($month, $year)
	{
		return static::findOne("month=? AND year=?", [$month, $year]);
	}
	
	public static function findAll($q = "", $values = null, $options = array())
	{
		if(empty($options))
			$options["orderBy"] = "year, month, name";
		return parent::findAll($q, $values, $options);
	}
}