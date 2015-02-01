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
	protected $response;
	protected $response_text;
	protected $request_text;
	
	private $_admin;
	private $_reviewer;
	private $_paper;
	
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
		if(self::DEFAULT_VALIDITY > 0){
			$r->expiry_date = Utils::dbDateFormat(time() + self::DEFAULT_VALIDITY * 24 * 3600);
			$r->permanent = false;
		}
		else {
			$r->permanent = true;
		}
		return $r;
	}
	
	/**
	 * checks whether the request is still valid
	 */
	private function checkValidity()
	{
		if($this->status == self::STATUS_PENDING && !$this->permanent){
			$date = $this->getExpiryDate();
			if($date && $date >= time()){
				$this->status == self::STATUS_INVALID;
				$this->save();
			}
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
	 * @param boolean $p
	 */
	public function setPermanent($p)
	{
		$this->permanent = $p;
	}
	
	/**
	 * whether the request never expires
	 * @return boolea
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
		$this->status = self::STATUS_CANCELLED;
	}
	
	/**
	 * set response given by reviewer
	 * @param number $response use a RESPONSE_* constant
	 * @param string $text
	 */
	public function setResponse($response, $text = "")
	{
		if(!$this->isValid()){
			throw new OperationException([OperationError::REVIEW_REQUEST_INVALID]);
		}
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
	
	protected function onInsert(&$errors)
	{
		//do not allow send a review request for a paper to reviewer who has a pending request
		//for the same paper
		if(static::findValidByPaperAndReviewer($this->getPaper(), $this->getReviewer())){
			$errors[] = OperationError::REVIEW_REQUEST_DUPLICATE_PENDING;
		}
		
		return true;
	}
	
	/**
	 * filters a list of review requests and returns only valid ones
	 * @param array(ReviewRequest) $requests
	 * @return array(ReviewRequest)
	 */
	private static function filterValid($requests)
	{
		return array_filter($requests, function($request){
			return $request->isValid();
		});
	}
	
	
	/**
	 * find the valid request with the given id
	 * @param number $code
	 * @return ReviewRequest
	 */
	public static function findValidById($id)
	{
		$req = static::findById($id);
		if($req && $req->isValid())
			return $req;
		return null;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @return array(ReviewRequest)
	 */
	public static function findValidByPaper($paper)
	{
		$reqs = static::findAllByField("paper_id", $paper->getId());
		return static::filterValid($reqs);
	}
	
	
	/**
	 * find the valid request for the given paper with the given id
	 * @param number $id
	 * @param Paper $paper
	 * @return ReviewRequest
	 */
	public static function findValidByIdAndPaper($id, $paper)
	{
		$req = static::findOne("id=? AND paper_id=?",
				[$id, $paper->getId()]);
		return $req && $req->isValid()? $req : null;
	}
	
	/**
	 * 
	 * @param Reviewer $reviewer
	 * @return array(ReviewRequest)
	 */
	public static function findValidByReviewer($reviewer)
	{
		$reqs = static::findAllByField("reviewer_id", $reviewer);
		return static::filterValid($reqs);		
	}
	
	/**
	 * 
	 * @param number $id
	 * @param Reviewer $reviewer
	 * @return ReviewRequest
	 */
	public static function findValidByIdAndReviewer($id, $reviewer)
	{
		$req = static::findOne("id=? AND reviewer_id=?",
				[$id, $paper->getId()]);
		return $req && $req->isValid()? $req : null;
	}
	
	/**
	 * 
	 * @param Paper $paper
	 * @param Reviewer $reviewer
	 * @return array(ReviewRequest)
	 */
	public static function findValidByPaperAndReviewer($paper, $reviewer)
	{
		$reqs = static::findAll("paper_id=? AND reviewer_id=?",[
				$paper->getId(), $reviewer->getId()
		]);
		
		return static::filterValid($reqs);
	}
	
	
}