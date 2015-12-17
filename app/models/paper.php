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
	protected $region;
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
	protected $workshop_id;
	protected $in_workshop;
	protected $viewed_by_admin;
	
	private $_researcher;
	private $_file;
	private $_cover;
	private $_authors = [];
	private $_authorsNames = [];
	private $_groups;
	private $_workshop;
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
	const STATUS_PIPELINE = "pipeline";
	const STATUS_WORKSHOP_QUEUE = "workshopQueue";
	const STATUS_POST_WORKSHOP_REVISION_MIN = "postWorkshopRevisionMin";
	const STATUS_POST_WORKSHOP_REVISION_MAJ = "postWorkshopRevisionMaj";
	const STATUS_POST_WORKSHOP_REVIEW_MIN = "postWorkshopReviewMin";
	const STATUS_ACCEPTED = "accepted";
	const STATUS_COMMUNICATIONS = "communications";
	
	
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
		$paper->in_workshop = false;
		$paper->viewed_by_admin = false;
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
	
	/**
	 * 
	 * @param boolean $v
	 */
	public function setViewedByAdmin($v)
	{
		$this->viewed_by_admin = $v;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function hasBeenViewedByAdmin()
	{
		return $this->viewed_by_admin;
	}
	
	
	
	/**
	 * 
	 * @param string $status
	 * @return string
	 */
	public static function getStatusStringStatic($status)
	{
		switch($status){
			case Paper::STATUS_GRACE_PERIOD:
				return "Grace Period";
			case Paper::STATUS_PENDING:
				return "Pending";
			case Paper::STATUS_REJECTED:
				return "Rejected";
			case Paper::STATUS_REVIEW:
				return "Ongoing review by external reviewer";
			case paper::STATUS_VETTING:
				return "Vetting in progress";
			case Paper::STATUS_REVIEW_REVISION_MAJ:
				return "Major revision in progress";
			case Paper::STATUS_REVIEW_REVISION_MIN:
				return "Minor revision in progress";
			case Paper::STATUS_REVIEW_SUBMITTED:
				return "Review submitted by external reviewer";
			case Paper::STATUS_VETTING_REVISION:
				return "Revision in progress after vetting";
			case Paper::STATUS_PIPELINE:
				return "Presentation Pipeline";
			case Paper::STATUS_WORKSHOP_QUEUE:
				return "In queue for workshop review";
			case Paper::STATUS_POST_WORKSHOP_REVIEW_MIN:
				return "Post workshop review";
			
			case Paper::STATUS_POST_WORKSHOP_REVISION_MAJ:
				return "Major revision in progress";
			case Paper::STATUS_POST_WORKSHOP_REVISION_MIN:
				return "Minor revision in progress";
			case Paper::STATUS_ACCEPTED:
				return "Accepted";
			case Paper::STATUS_COMMUNICATIONS:
				return "Sent to communications";
			default:
				return $status;
		}
	}
	
	public function getStatusString()
	{
		return static::getStatusStringStatic($this->status);
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
		return (boolean) $this->editable;
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
	 * whether paper is in presentation pipeline
	 * @return boolean
	 */
	public function isInPipeline()
	{
		return $this->status == self::STATUS_PIPELINE;
	}
	
	/**
	 * whether the paper is in a workshop queue
	 * @return boolean
	 */
	public function isInWorkshop()
	{
		return (boolean) $this->in_workshop;
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
			//TODO throw exception instead
			return false;
		}
		
		array_splice($this->authors_names, $i, 1);
		array_splice($this->authors, $i, 1);
		
		$pAuthor->delete();
		
		return true;
	}
	
	/**
	 * 
	 * @param in_workshop $workshop
	 */
	public function addToWorkshopQueue($workshop)
	{
		$errors = [];
		if($this->status == Paper::STATUS_WORKSHOP_QUEUE)
			$errors[] = OperationError::PAPER_ALREADY_IN_WORKSHOP;
		else if($this->status != Paper::STATUS_PIPELINE)
			$errors[] = OperationError::PAPER_NOT_PENDING;
		
		if(!empty($errors))
			throw new OperationException($errors);
		$this->workshop_id = $workshop->getId();
		$this->_workshop = $workshop;
		$this->status = Paper::STATUS_WORKSHOP_QUEUE;
		//add paper to workshop queue
		if(!$this->in_workshop)
			$this->in_workshop = true;
	}
	
	/**
	 * remove paper from biannual workshop queue and return to pending status
	 */
	public function removeFromWorkshopQueue()
	{
		$errors = [];
		if(!$this->getWorkshop() || $this->status != self::STATUS_WORKSHOP_QUEUE)
			$errors[] = OperationError::PAPER_NOT_IN_WORKSHOP;
		if(!empty($errors))
			throw new OperationException($errors);
		$this->workshop_id = null;
		$this->_workshop = null;
		$this->status = Paper::STATUS_PIPELINE;
		$this->in_workshop = false;
		$this->resetNextActionsList();
		$this->addNextAction(self::ACTION_WORKSHOP_QUEUE);
		$this->addNextAction(self::ACTION_EXTERNAL_REVIEW);
	}
	
	/**
	 * get workshop for which this paper has been scheduled for review
	 * @return Workshop
	 */
	public function getWorkshop()
	{
		if(!$this->_workshop)
			$this->_workshop = Workshop::findById($this->workshop_id);
		return $this->_workshop;
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
	 * advance paper to the next level
	 */
	public function advanceLevel()
	{
		switch($this->level){
			case PaperLevel::PROPOSAL:
			case PaperLevel::R_PROPOSAL:
				$this->level = PaperLevel::WIP;
				break;
			case PaperLevel::WIP:
			case PaperLevel::R_WIP:
				$this->level = PaperLevel::FINAL_REPORT;
				break;
			case PaperLevel::FINAL_REPORT;
			case PaperLevel::R_FINAL_REPORT:
				$this->status = self::STATUS_ACCEPTED;
				break;
		}
	}
	
	/**
	 * set this paper to the revised version of it's current level
	 */
	public function setToRevisedLevel()
	{
		switch($this->level){
			case PaperLevel::PROPOSAL:
			case PaperLevel::R_PROPOSAL:
				$this->level = PaperLevel::R_PROPOSAL;
				break;
			case PaperLevel::WIP:
			case PaperLevel::R_WIP:
				$this->level = PaperLevel::R_WIP;
				break;
			case PaperLevel::FINAL_REPORT:
			case PaperLevel::R_FINAL_REPORT:
				$this->level = PaperLevel::R_FINAL_REPORT;
		}
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isProposal()
	{
		return $this->level == PaperLevel::PROPOSAL;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isRevisedProposal()
	{
		return $this->level == PaperLevel::R_PROPOSAL;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isProposalOrRevised()
	{
		return $this->isProposal() || $this->isRevisedProposal();
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isWip()
	{
		return $this->level == PaperLevel::WIP;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isRevisedWip()
	{
		return $this->level == PaperLevel::R_WIP;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isWipOrRevised()
	{
		return $this->isWip() || $this->isRevisedWip();
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isFinalReport()
	{
		return $this->level == PaperLevel::FINAL_REPORT;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isRevisedFinalReport()
	{
		return $this->level == PaperLevel::R_FINAL_REPORT;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isFinalReportOrRevised()
	{
		return $this->isFinalReport() || $this->isRevisedFinalReport();
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
		//TODO: verify whether paper should go to presentation pipeline automatically after revision
		$this->status = self::STATUS_PIPELINE;
		$this->editable = false;
		$this->incrementRevision();
		$this->resetNextActionsList();
		$this->addNextAction(self::ACTION_WORKSHOP_QUEUE);
		$this->addNextAction(self::ACTION_EXTERNAL_REVIEW);
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
				$this->status  = self::STATUS_PIPELINE;
				$this->resetNextActionsList();
				$this->addNextAction(self::ACTION_EXTERNAL_REVIEW);
				$this->addNextAction(self::ACTION_WORKSHOP_QUEUE);
				break;
			case Review::VERDIC_WORKSHOP_APPROVED:
				$this->status = self::STATUS_PIPELINE;
				$this->resetNextActionsList();
				$this->addNextAction(self::ACTION_WORKSHOP_QUEUE);
				break;
			case Review::VERDICT_REVISION_MAJ:
				$this->editable = true;
				$this->status = self::STATUS_REVIEW_REVISION_MAJ;
				break;
			case Review::VERDICT_WORKSHOP_REVISION:
				$this->editable = true;
				$this->status = self::STATUS_POST_WORKSHOP_REVISION_MAJ;
				break;
			case Review::VERDICT_REVISION_MIN:
				$this->editable = true;
				$this->status = self::STATUS_REVIEW_REVISION_MIN;
				break;
			case Review::VERDICT_REJECTED:
			case Review::VERDICT_WORKSHOP_REJECTED;
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
	 * @return WorkshopReview
	 */
	public function findRecentlySubmittedWorkshopReview()
	{
		return WorkshopReview::findRecentlySubmittedByPaper($this);
	}
	
	public function submitWorkshopReview($verdict)
	{
		$review = WorkshopReview::findCurrentByPaper($this);
		
		$review->submit($verdict);
		$review->save();
		switch($verdict){
			case WorkshopReview::VERDICT_APPROVED:
				//do not allow to workshop queue if we're approving a final report
				//because it goes into accepted state where it can be sent to comms
				$this->status = self::STATUS_PENDING;
				$allowAddToQueue = !$this->isFinalReportOrRevised();
				$this->advanceLevel();				
				$this->resetNextActionsList();
				if($allowAddToQueue){
					$this->status = self::STATUS_PIPELINE;
					$this->addNextAction(self::ACTION_WORKSHOP_QUEUE);
				}
				break;
			case WorkshopReview::VERDICT_REVISION_MIN:
				$this->status = self::STATUS_POST_WORKSHOP_REVISION_MIN;
				$this->editable = true;
				break;
			case WorkshopReview::VERDICT_REVISION_MAJ:
				$this->setToRevisedLevel();
				$this->status = self::STATUS_POST_WORKSHOP_REVISION_MAJ;
				$this->editable = true;
				break;
			
			case WorkshopReview::VERDICT_REJECTED:
				$this->status = self::STATUS_REJECTED;
				break;
				
		}
		
		$this->save();
		return $review;
	}
	
	public function submitPostWorkshopReviewMin($verdict)
	{
		$review = PostWorkshopReviewMin::findCurrentByPaper($this);
		$review->submit($verdict);
		$review->save();
		switch($verdict){
			case PostWorkshopReviewMin::VERDICT_APPROVED:
				//do not allow to workshop queue if we're approving a final report
				//because it goes into accepted state where it can be sent to comms
				$allowAddToQueue = !$this->isFinalReportOrRevised();
				$this->status = self::STATUS_PENDING;
				$this->resetNextActionsList();
				$this->advanceLevel();
				if($allowAddToQueue){
					$this->status = self::STATUS_PIPELINE;
					$this->addNextAction(self::ACTION_WORKSHOP_QUEUE);
				}
				
				break;
			case PostWorkshopReviewMin::VERDICT_REJECTED:
				$this->status = self::STATUS_POST_WORKSHOP_REVISION_MIN;
				$this->editable = true;
				break;
		}
		$this->save();
		return $review;
	}
	
	public function workshopReviewResubmitMin()
	{
		$this->status = self::STATUS_POST_WORKSHOP_REVIEW_MIN;
		$this->editable = false;
		$this->incrementRevision();
		$this->save();
	}
	
	public function workshopReviewResubmitMaj()
	{
		$this->status = self::STATUS_PENDING;
		$this->resetNextActionsList();
		$this->addNextAction(self::ACTION_EXTERNAL_REVIEW);
		$this->editable = false;
		$this->incrementRevision();
		$this->save();
	}
	
	public function sendToCommunications()
	{
		$this->status = self::STATUS_COMMUNICATIONS;
	}
	
	/**
	 * find all papers, first those not viewed by admin then in reverse
	 * chronological order
	 * @param string $q
	 * @param string $values
	 * @param array $options
	 * @return array(Paper)
	 */
	public static function findAll($q = "", $values = null, $options = array())
	{
		if(!$options)
			$options = ["orderBy"=>"viewed_by_admin, date_submitted DESC"];
		return parent::findAll($q, $values, $options);
	}

	/**
	 * 
	 * @param User $researcher
	 * @return array(Paper)
	 */
	public static function findByResearcher($researcher)
	{
		return static::findAllByField("researcher_id", $researcher->getId(), ["orderBy"=>"date_submitted DESC"]);
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
	
	/**
	 * 
	 * @return Paper
	 */
	public static function findInPresentationPipeline()
	{
		return static::findByField('status', self::STATUS_PIPELINE);
	}
	
	/**
	 * 
	 * @param Workshop $workshop
	 * @return array(Paper)
	 */
	public static function findByWorkshop($workshop)
	{
		return static::findAll("workshop_id=? AND (status=?)",[
				$workshop->getId(), Paper::STATUS_WORKSHOP_QUEUE
		]);
	}
	
	
	/**
	 * find all papers not viewed by admin
	 * @return array(Paper)
	 */
	public static function findUnread()
	{
		return static::findAllByField("viewed_by_admin", false);
	}
	
	/**
	 * counts the number of papers not viewed by admin
	 * @return number
	 */
	public static function countUnread()
	{
		return static::countByField("viewed_by_admin", false);
	}
	
}