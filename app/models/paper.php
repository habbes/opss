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
	protected $other_parts;
	protected $thematic_area;
	
	private $_researcher;
	private $_file;
	private $_cover;
	private $_authors = [];
	private $_authorsNames = [];
	private $_groups;
	private $_jsonLoaded = false;
	private $_nextActions = [];
	private $_statusMessages = [];

	
	const DIR = "papers";
	const GRACE_PERIOD = 2; //days
	
	//status
	const STATUS_GRACE_PERIOD = "grace";
	const STATUS_PENDING = "pending";
	const STATUS_VETTING = "vetting";
	const STATUS_VETTING_REVISION = "vettingRewrite";
	const STATUS_REVIEW = "review";
	const STATUS_REVIEW_REVISION_MAJ = "reviewRevisionMaj";
	const STATUS_REVIEW_REVISION_MIN = "reviewRevisionMin";
	const STATUS_REVIEW_SUBMITTED = "reviewSubmitted";
	const STATUS_REJECTED = "rejected";
	
	//status messages
	const STATMSG_NEW_PAPER = "new";
	const STATMSG_RESUBMITTED_AFTER_VET_REVISION = "resubmittedAfterVetRevision";
	const STATMSG_REVIEW_SUBMITTED = "new";
	
	//next actions
	const ACTION_EXTERNAL_REVIEW = "externalReview";
	const ACTION_WORKSHOP_QUEUE = "workshopQueue";
	
	
	
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
		$paper->status = Paper::STATUS_GRACE_PERIOD;
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
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}
	
	public function getThematicArea()
	{
		return $this->thematic_area;
	}
	
	public function setThematicArea($area)
	{
		$this->thematic_area = $area;
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
	 * @return string
	 */
	public function getRevisionIdentifier()
	{
		return sprintf("%s-%d",$this->identifier, $this->getRevision());
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getAbsoluteUrl()
	{
		return sprintf("%s/papers/%s", URL_ROOT, $this->identifier);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getRelativeUrl()
	{
		return sprintf("/papers/%s", $this->identitifer);
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
		$this->setRevision($this->getRevision() + 1);
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
	
	/**
	 * decode the json text containing other info such as nextActions
	 * and set the values to the corresponding properties
	 */
	private function loadOtherParts()
	{
		if(!$this->_jsonLoaded){
			if($this->other_parts){
				$json = json_decode($this->other_parts);
				$this->_nextActions = $json->nextActions? $json->nextActions : [];
				$this->_statusMessages = $json->statusMessages? $json->statusMessages : [];
			}
			$this->_jsonLoaded = true;
		}
	}
	
	/**
	 * encode and save additional info such as nextActions
	 */
	private function saveOtherParts()
	{
		$other_parts = [
				"nextActions" => $this->_nextActions,
				"statusMessages" => $this->_statusMessages
		];
		$this->other_parts = json_encode($other_parts);
	}
	
	/**
	 * returns a list of possible actions that can be taken on this paper if it is in
	 * a pending state
	 * @return array(string)
	 */
	public function getNextActions()
	{
		$this->loadOtherParts();
		return $this->_nextActions;
	}
	
	/**
	 * add an action that can be performed next on this paper
	 * @param string $action one of the ACTION_* constants
	 */
	public function addNextAction($action)
	{
		$this->loadOtherParts();
		$this->_nextActions[] = $action;
	}
	
	/**
	 * add a list of actions that can be performed next on this paper
	 * @param array $actions use the ACTION_* constants
	 */
	public function addNextActions($actions)
	{
		$this->loadOtherParts();
		$this->_nextActions = array_merge($this->_nextActions, $actions);
	}
	
	/**
	 * remove of all actions currently in the nextActions list
	 */
	public function resetNextActionsList()
	{
		$this->loadOtherParts();
		$this->_nextActions = [];
	}
	
	/**
	 * adds a message that is meant to be displayed on this paper's page
	 * @param string $message use the STATMSG_* constants
	 */
	public function addStatusMessage($message)
	{
		$this->loadOtherParts();
		$this->_statusMessages[] = $message;
	}
	
	/**
	 * 
	 * @param array $messages use the STATMSG_* constants as elements of the array
	 */
	public function addStatusMessages($messages)
	{
		$this->loadOtherParts();
		$this->_statusMessages = array_merge($this->_statusMessages, $messages);
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getStatusMessages()
	{
		$this->loadOtherParts();
		return $this->_statusMessages;
	}
	
	/**
	 * delete the status message if it's in the list
	 * @param string $message user the STATMSG_* constants
	 */
	public function deleteStatusMessage($message)
	{
		$this->loadOtherParts();
		$i = array_search($message, $this->_statusMessages);
		if($i !== false)
			$this->_statusMessages = array_splice($this->_statusMessages, $i, 1);
	}
	
	/**
	 * removes all status messages
	 */
	public function resetStatusMessagesList()
	{
		$this->loadOtherParts();
		$this->_statusMessages = [];
	}
	
	/**
	 * gets all history events for this paper
	 * @return array(PaperChange)
	 */
	public function getChanges()
	{
		return PaperChange::findByPaper($this);
	}

	/**
	 * 
	 * @return array(ReviewRequest)
	 */
	public function getValidReviewRequests()
	{
		return ReviewRequest::findValidByPaper($this);
	}
	
	/**
	 * 
	 * @param number $id
	 * @return ReviewRequest
	 */
	public function getValidReviewRequestById($id)
	{
		return ReviewRequest::findValidByIdAndPaper($id, $this);
	}
	
	/**
	 * 
	 * @param number $id
	 * @return PaperChange
	 */
	public function getChangeById($id)
	{
		return PaperChange::findByPaperAndId($this, $id);
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
		if($this->thematic_area && !PaperGroup::isValue($this->thematic_area))
			$errors[] = OperationError::PAPER_THEMATIC_AREA_INVALID;
		
		//save other parts
		$this->saveOtherParts();
		
		
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
		$this->status = self::STATUS_VETTING;
		$this->editable = false;
		$this->recallable = false;
		$this->save();
	}
	
	/**
	 * resubmit paper for vetting (after revision)
	 */
	public function vettingResubmit()
	{
		$this->status = self::STATUS_VETTING;
		$this->editable = false;
		$this->addStatusMessage(self::STATMSG_RESUBMITTED_AFTER_VET_REVISION);
		$this->save();
	}
	
	public function reviewResubmit()
	{
		$this->status = self::STATUS_PENDING;
		$this->editable = false;
		$this->incrementRevision();
		$this->resetNextActionsList();
		$this->addNextAction(self::ACTION_EXTERNAL_REVIEW);
		$this->addNextAction(self::ACTION_WORKSHOP_QUEUE);
		$this->resetStatusMessagesList();
		$this->save();
	}
	
	/**
	 * 
	 * @param Reviewer $reviewer
	 * @param Admin $admin
	 */
	public function sendForReview($reviewer, $admin)
	{
		$this->status = self::STATUS_REVIEW;
		$review = Review::create($this, $reviewer, $admin);
		$review->save();
		$this->save();
	}
	
	/**
	 * 
	 * @return Review
	 */
	public function getCurrentReview()
	{
		return Review::findCurrentByPaper($this);
	}
	
	/**
	 * 
	 * @return Review
	 */
	public function getLatesReview()
	{
		$rvs = Review::findByPaper($this);
		return array_pop($rvs);
	}
	
	/**
	 * @return User
	 */
	public function getCurrentReviewer()
	{
		if($review = $this->getCurrentReview()){
			return $review->getReviewer();
		}
		return null;
	}
	
	/**
	 * 
	 * @return Review
	 */
	public function getRecentlySubmittedReview()
	{
		return Review::findRecentlySubmittedByPaper($this);
	}
	
	/**
	 * submit the ongoing review and saves
	 * @param number $recommendation values are Review::VERDICT_* constants
	 * @return Review the submitted review
	 */
	public function submitReview($recommendation)
	{
		$review = $this->getCurrentReview();
		$review->submit($recommendation);
		$review->save();
		$this->status = self::STATUS_REVIEW_SUBMITTED;		
		$this->save();
		return $review;
	}
	
	/**
	 * 
	 * @param string $verdict
	 * @throws OperationException
	 * @return Review the submitted review
	 */
	public function submitAdminReview($verdict)
	{
		$review = $this->getRecentlySubmittedReview();
		$review->submitAdminReview($verdict);
		$review->save();
		switch($verdict){
			case Review::VERDICT_APPROVED:
				$this->status  = self::STATUS_PENDING;
				$this->resetNextActionsList();
				$this->addNextAction(self::ACTION_EXTERNAL_REVIEW);
				$this->addNextAction(self::ACTION_WORKSHOP_QUEUE);
				break;
			case Review::VERDICT_REVISION_MAJ:
				$this->status = self::STATUS_REVIEW_REVISION_MAJ;
				break;
			case Review::VERDICT_REVISION_MIN:
				$this->status = self::STATUS_REVIEW_REVISION_MIN;
				break;
			case Review::VERDICT_REJECTED:
				$this->status = self::STATUS_REJECTED;
				break;
			default:
				throw new OperationException([OperationError::REVIEW_VERDICT_INVALID]);
				
		}
		
		$this->save();
		return $review;
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