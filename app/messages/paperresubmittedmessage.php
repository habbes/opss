<?php

/**
 * notification sent to admin and researcher after paper has been resubmitted
 * @author Habbes
 *
 */
class PaperResubmittedMessage extends Message
{
	/**
	 * 
	 * @param Paper $paper
	 * @param User $recipient
	 * @return PaperResubmittedMessage
	 */
	public static function create($paper, $recipient)
	{
		$m = new static();
		$m->setSubject("Paper Resubmitted");
		$m->attachPaper($paper);
		$m->setUser($user);
		switch($user->getType()){
			case UserType::ADMIN:
				$m->setMessageFromTemplate("paper-resubmitted-admin",[
					"title" => $paper->getTitle(),
					"identifier" => $paper->getIdentifier(),
					"author" => $paper->getResearcher()->getFullName()
				]);
				break;
			case UserType::RESEARCHER:
				$m->setMessageFromTemplate("paper-resubmitted-researcher",[
					"title" => $paper->getTitle(),
					"identifier" => $paper->getIdentifier()
				]);
			break;
		}
		
		return $m;
	}
}