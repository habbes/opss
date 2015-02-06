<?php

class Workshop extends DBModel
{
	protected $year;
	protected $month;
	
	public static function create($year, $month)
	{
		$w = new static();
		$w->year = $year;
		$w->month = $month;
		return $w;
	}
	
	public function getYear()
	{
		return $this->year;
	}
	
	public function getMonth()
	{
		return $this->month;
	}
	
	public function getAbsoluteUrl()
	{
		return URL_ROOT."/workshops/".$this->getStringId();
	}
	
	public function toString()
	{
		return self::getMonthString($this->month). " " . $this->getYear();
	}
	
	public function getStringId()
	{
		return self::getMonthString($this->month). "-" . $this->getYear();
	}
	
	/**
	 * 
	 * @return array(Paper)
	 */
	public function getPapers()
	{
		return paper::findByWorkshop($this);
	}
	
	public function onInsert(&$errors)
	{
		if(!$this->month)
			$errors[] = OperationError::WORKSHOP_MONTH_EMPTY;
		if(!array_key_exists($this->month, static::getMonthStrings()))
			$errors[] = OperationError::WORKSHOP_MONTH_INVALID;
		if(!$this->year)
			$errors[] = OperationError::WORKSHOP_YEAR_EMPTY;
		if(static::findByMonthAndYear($this->month, $this->year))
			$errors[] = OperationError::WORKSHOP_EXISTS;
		return true;
	}
	
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
	
	public static function getMonthString($month)
	{
		return static::getMonthStrings()[$month];
	}
	
	public static function getMonthNumber($month)
	{
		foreach(self::getMonthStrings() as $num => $string){
			if(strtolower($string) == strtolower($month))
				return $num;
		}
	}
	
	
	
	public static function findByMonthAndYear($month, $year)
	{
		return static::findOne("month=? AND year=?", [$month, $year]);
	}
}