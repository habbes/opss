<?php

class PaperSentForReviewMessage extends Message
{
	/**
	 * 
	 * @param User $recipient
	 * @param Paper $paper
	 * @param User $reviewer
	 * @return PaperSentForReviewMessage
	 */
	public static function create($recipient, $paper, $reviewer)
	{
		$m = new static();
		$m->setUser($recipient);
		$m->attachPaper($paper);
		$m->setSubject("Paper Sent For Review");
		switch($recipient->getType()){
			case UserType::ADMIN:
				$m->setMessageFromTemplate("paper-sent-for-review-admin",[
					"title" => $paper->getTitle(),
					"identifier" => $paper->getIdentifier(),
					"reviewerName" => $reviewer->getFullName()
				]);
				$m->attachUser($reviewer);
				break;
			case UserType::RESEARCHER:
				$m->setMessageFromTemplate("paper-sent-for-review-researcher",[
						"title" => $paper->getTitle(),
						"identifier" => $paper->getIdentifier(),
				]);
				break;
			case UserType::REVIEWER:
				$m->setMessageFromTemplate("paper-sent-for-review-reviewer",[
					"title" => $paper->getTitle(),
					"identifier" => $paper->getIdentifier(),
				]);
				$m->setSubject("Accepted To Review Paper");
				break;
		}
		
		return $m;
	}
}