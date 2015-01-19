<?php

/**
 * message sent to admin and researcher when paper is vetted
 * @author Habbes
 *
 */
class PaperVettedMessage extends Message
{
	/**
	 * 
	 * @param Paper $paper
	 * @param string $verdict verdict of the vet review
	 * @param User $recipient
	 * @return PaperVettedMessage
	 */
	public static function create($paper, $verdict, $recipient)
	{
		$m = new static();
		$m->setSubject("Paper Vetted");
		$m->attachPaper($paper);
		
		switch($recipient->getType()){
			case UserType::ADMIN:
				$template = $verdict == VetReview::VERDICT_ACCEPTED? 
					"paper-vetted-accepted-admin" : "paper-vetted-rejected-admin";
				$m->setMessageFromTemplate($template,[
					"title" => $paper->getTitle(),
					"identifier" => $paper->getIdentifier(),
					"author" => $paper->getResearcher()->getFullName(),	
				]);
				break;
			case UserType::RESEARCHER:
				$template = $verdict == VetReview::VERDICT_ACCEPTED?
					"paper-vetted-accepted-researcher" : "paper-vetted-accepted-researcher";
				$m->setMessageFromTemplate($template, [
						"title" => $paper->getTitle(),
						"identifier" => $paper->getIdentifier(),
				]);
				
				break;
		}
		
		$m->setUser($recipient);
		return $m;
	}
}