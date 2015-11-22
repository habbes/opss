<?php

class NewReviewerInvitationEmail extends Email
{
	/**
	 * 
	 * @param string $name
	 * @param string $email
	 * @param Paper $paper
	 * @param RegInvitation $regInvitation
	 * @return NewReviewerInvitationEmail
	 */
	public static function create($name, $email, $paper, $regInvitation)
	{
		$e = new static();
		$e->setBodyFromTemplate("reviewer-invitation",[
			"name" => $name,
			"title" => $paper->getTitle(),
			"acceptLink" => URL_ROOT."/registration?invitation=".$regInvitation->getRegistrationCode(),
			"declineLink" => URL_ROOT."/invitation-declined?reg-code=".$regInvitation->getRegistrationCode(),
			"payment" => $regInvitation->getPayment(),
		]);
		
		$e->innerMsg->addTo($email, $name);
		
		$e->attachFile($paper->getFile());
		$e->setSubject("Invitation to review paper");
		
		return $e;
	}
}