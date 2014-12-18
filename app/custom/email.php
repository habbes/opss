<?php

class Email extends View
{
	
	protected $innerMsg;
	
	public function __construct()
	{
		$this->innerMsg = new Swift_Message();
		parent::__construct();	
	}

	/**
	 * returns the email template file
	 * @param string $template
	 * @return string
	 */
	public function template($template)
	{
		$ds = DIRECTORY_SEPARATOR;
		return DIR_VIEWS . $ds ."_templates" . $ds . "emails" . $ds . str_replace("/",$ds,$template).".php";
	}
	
	/**
	 * 
	 * @param string $subj
	 */
	public function setSubject($subj)
	{
		$this->innerMsg->setSubject($subj);
	}
	
	/**
	 * 
	 * @param string $email
	 * @param string $name
	 */
	public function addRecipient($email, $name = "")
	{
		if($name){
			$this->innerMsg->addTo($email, $name)
		}
		else {
			$this->innerMsg->addTo($email);
		}
	}
	
	/**
	 * adds the following user to the recipient list
	 * @param User $user
	 */
	public function addUser($user)
	{
		$this->addRecipient($user->getEmail(), $user->getFullName());
	}
	
	/**
	 * set the html body of this email
	 * @param string $content
	 */
	public function setBody($content)
	{
		$this->innerMsg->setBody($content, "text/html");
		$this->innerMsg->addPart(html_entity_decode(strip_tags($content)), "text/plain");
	}
	
	/**
	 * sets the body of the message with the template saved on the file
	 * @param unknown $template
	 */
	public function setBodyFromTemplate($template, $args = array)
	{
		$this->data->loadData($args);
		$this->setBody($this->read($template));
	}
	
	/**
	 * adds another part to the email
	 * @param string $content
	 * @param string $type the mime content type
	 */
	public function addPart($content, $type="")
	{
		$this->innerMsg->addPart($content, $type);
	}
	
	/**
	 * adds an attachment from the specified path
	 * @param string $path the location of the file
	 * @param string $type mime content type
	 */
	public function attachFromPath($path, $filename, $type)
	{
		$this->innerMsg->attach(
				Swift_Attachment::fromPath($path, $type)->setFilename($filename);
		);
	}	
	
	/**
	 * adds an attachement from the given file object
	 * @param File $file
	 */
	public function attachFile($file)
	{
		$this->attachFromPath($file->getFilepath(), $file->getFilename(), $file->getFiletype());
	}
	
	/**
	 * sends this email
	 * @return number the number of successful emails
	 */
	public function send()
	{
		return Mailer::send($this->innserMsg);
	}
	
}