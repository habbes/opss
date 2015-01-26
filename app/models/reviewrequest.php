<?php

/**
 * represents a request sent by the admin to an existing review to review a paper
 * @author Habbes
 *
 */
class ReviewRequest extends DBModel
{
	
	protected $admin_id;
	protected $reviewer_id;
	protected $paper_id;
	protected $date_sent;
	protected $date_responded;
	protected $status;
	protected $permanent;
	protected $expiry_date;
	protected $code;
	protected $response;
	protected $response_text;
	protected $request_text;
	
	private $_admin;
	private $_reviewer;
	private $_paper;
	
	const STATUS_PENDING = 'pending';
	const STATUS_INVALID = 'invalid';
	const STATUS_RESPONDED = 'responded';
	
	const RESPONSE_ACCEPTED = 'accepted';
	const RESPONSE_REJECTED = 'rejected';
	
	/**
	 * 
	 * @param User $admin
	 * @param User $reviewer
	 * @param Paper $paper
	 * @return ReviewRequest
	 */
	public static function create($admin, $reviewer, $paper)
	{
		$r = new static();
		$r->admin_id = $admin->getId();
		$r->_admin = $admin;
		$r->reviewer_id = $reviewer->getId();
		$r->_reviewer = $reviewer;
		$r->paper_id = $paper->getId();
		$r->_paper = $paper;
		$r->date_sent = Utils::dbDateFormat(time());
		$r->status = self::STATUS_PENDING;
		$r->code = Utils::uniqueRandomCode();
		return $r;
	}
	
	//status
	const STATUS_PENDING = "pending";
	const STATUS_EXPIRED = "invalid";
	const STATUS_CANCELLED = "cancelled";
	const STATUS_RESPONDED = "responded";
	
	//response
	const RESPONSE_ACCEPTED = "accepted";
	const RESPONSE_REJECTED = "rejected";
	
	const DEFAULT_VALIDITY  = 0;
	
	/**
	 * checks whether the request is still valid
	 */
	private function checkValidity()
	{
		if($this->status != self::STATUS_CANCELLED)
			return;
		$date = $this->getExpiryDate();
		if($date && $date >= time()){
			$this->status == self::STATUS_INVALID;
			$this->save();
		}
	}
	
	/**
	 * admin who sent the request
	 * @return User
	 */
	public function getAdmin()
	{
		if(!$this->_admin)
			$this->_admin = User::findById($this->admin_id);
		return $this->_admin;
	}
	
	/**
	 * reviewer to whom request is sent
	 * @return User
	 */
	public function getReviewer()
	{
		if(!$this->_reviewer)
			$this->_reviewer = User::findById($this->reviewer_id);
			return $this->_reviewer;
	}
	
	/**
	 * paper to review
	 * @return Paper
	 */
	public function getPaper()
	{
		if(!$this->_paper)
			$this->_paper = Paper::findById($this->paper_id);
			return $this->_paper;
	}
	
	/**
	 * sets whether this request never expires
	 * @param unknown $p
	 */
	public function setPermanent($p)
	{
		$this->permanent = $p;
	}
	
	/**
	 * whether the request never expires
	 * @return unknown
	 */
	public function isPermanent()
	{
		return $this->permanent;
	}
	
	/**
	 * @return number timestamp
	 */
	public function getExpiryDate()
	{
		return strtotime($this->expiry_date);
	}
	
	/**
	 * 
	 * @param number $date timestamp
	 */
	public function setExpiryDate($date)
	{
		$this->expiry_date = Utils::dbDateFormat($date);
	}
	
	/**
	 * 
	 * @return number timestamp
	 */
	public function getDateSent()
	{
		return strtotime($this->date_sent);
	}
	
	/**
	 * @return number timestamp
	 */
	public function getDateResponded()
	{
		return strotime($this->date_responded);
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isValid()
	{
		$this->checkValidity();
		return $this->status == self::STATUS_PENDING;
	}
	
	/**
	 * text to sent from the admin along with the request
	 * @param string $text
	 */
	public function setRequestText($text)
	{
		$this->response_text = $text;
	}
	
	/**
	 * text to sent from the reviewer along with the response
	 * @param unknown $text
	 */
	public function setResponseText($text)
	{
		$this->response_text = $text;
	}
	
	
	/**
	 * cancel the request
	 */
	public function cancel()
	{
		$this->status == self::STATUS_INVALID;
	}
	
	public function setResponse($response, $text = "")
	{
		$this->response = $response;
		$this->response_text = $text;
		$this->date_responded = time();
		$this->status = self::STATUS_RESPONDED;
	}
	
	/**
	 * accept the request
	 */
	public function accept()
	{
		$this->setResponse(self::RESPONSE_ACCEPTED);
	}
	
	/**
	 * decline the request
	 */
	public function reject()
	{
		$this->setResponse(self::RESPONSE_REJECTED);
		
	}
	
	public function isAccepted()
	{
		return $this->status == self::STATUS_RESPONDED && $this->response = self::RESPONSE_ACCEPTED;
	}
	
	public function isRejected()
	{
		return $this->status == self::STATUS_RESPONDED && $this->response = self::RESPONSE_REJECTED;
	}
	
	/**
	 * find the valid request with the given code
	 * @param string $code
	 * @return ReviewRequest
	 */
	public static function findValidByCode($code)
	{
		$req = static::findOne("code", $code);
		if($req && $req->isValid())
			return $req;
		return null;
	}
	
	/**
	 * find a valid request for the given paper with the given code
	 * @param string $code
	 * @param Paper $paper
	 * @return ReviewRequest
	 */
	public static function findValidByCodeAndPaper($code, $paper)
	{
		$req = static::findOne("code=? AND paper_id=?",
				[$code, $paper->getId()]);
		if($req && $req->isValid())
			return $req;
		return null;		
	}
	
}