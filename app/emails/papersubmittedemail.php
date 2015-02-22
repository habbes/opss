<?php

/**
 * email sent to admin to notify of a new paper submission
 * @author Habbes
 *
 */
class PaperSubmittedEmail extends Email
{
	/**
	 * 
	 * @param Recipient $recipient
	 * @param Paper $paper
	 * @return PaperSubmittedEmail
	 */
	public static function create($recipient, $paper)
	{
		$e = new static();
		$e->addUser($recipient);
		$e->setSubject("Paper Submitted");
		$e->setBodyFromTemplate("paper-submitted-admin", [
				"name" => $recipient->getFullName(),
				"title" => $paper->getTitle(),
				"identifier" => $paper->getIdentifier(),
				"paperLink" => $paper->getAbsoluteUrl(),
				"researcher" => $paper->getResearcher()->getFullName(),
				"researcherLink" => $paper->getResearcher()->getAbsoluteUrl()
		]);
		
		return $e;
	}
}