<?php

/**
 * message sent to researcher and admin when paper is submitted
 * @author Habbes
 *
 */
class PaperSubmittedMessage extends Message
{
	/**
	 * 
	 * @param Paper $paper
	 * @parama User $User recipient
	 * @return PaperSubmittedMessage
	 */
	public static function create($paper, $user)
	{
		$m = new static();
		$m->setSubject("Paper Submitted");
		$m->attachPaper($paper);
		
		switch($user->getType()){
			case UserType::ADMIN:
				$m->setMessageFromTemplate("paper-submitted-admin",
					[
						"author" => $paper->getResearcher()->getFullName(),
						"title" => $paper->getTitle()
					]
				);
				break;
			case UserType::RESEARCHER:
				$m->setMessageFromTemplate("paper-submitted-researcher",
					[
						"title" => $paper->getTitle()
					]
				);
				break;
		}
		
		$m->setUser($user);
		
		return $m;
		
	}
}