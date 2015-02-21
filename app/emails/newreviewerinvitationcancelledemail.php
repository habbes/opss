<?php

/**
 * email sent to invited reviewer to notify invitation is cancelled
 * @author Habbes
 *
 */
class NewReviewerInvitationCancelledEmail extends Email
{
	/**
	 * 
	 * @param string $name
	 * @param string $email
	 * @param Paper $paper
	 * @param RegInvitation $invitation
	 * @return NewReviewerInvitationEmail
	 */
	public static function create($name, $email, $paper)
	{
		$e = new static();
		$e->setBodyFromTemplate("reviewer-invitation-cancelled",[
			"name" => $name,
			"title" => $paper->getTitle()
		]);
		
		$e->addRecipient($email, $name);
		$e->setSubject("Invitation Cancelled");
		
		return $e;
	}
}