<?php

/**
 * class used to send messages from templates
 * @author Habbes
 *
 */
class TemplateMessage
{
	
	/**
	 * 
	 * @var Message
	 */
	protected $innerMsg;
	
	public function __construct()
	{
		$this->innserMsg = new Message();
	}
	
	/**
	 * return the message template file
	 * @param string $template
	 * @return string
	 */
	public function template($template)
	{
		$ds = DIRECTORY_SEPARATOR;
		return DIR_MESSAGE_TEMPLATES.$ds.str_replace("/",$ds,$template)."php";
	}
	
	/**
	 * gets the inner Message
	 * @return Message
	 */
	public function getMessage()
	{
		return $this->innerMsg;
	}
	
	/**
	 * adds a recipient to the message
	 * @param User $user
	 */
	public function setUser($user)
	{
		$this->innerMsg->setUser($user);
	}
	
	/**
	 * 
	 * @param string $content
	 */
	public function setBody($content)
	{
		$this->innerMsg->setMessage($content);
	}
	
	/**
	 * 
	 * @param string $template
	 * @param array $vars
	 */
	public function setBodyFromTemplate($template, $vars = array())
	{
		$path = $this->template($template);
		$mt = new MessageTemplate();
		$mt->setTemplatePath($path);
		$mt->setVars($vars);
		$this->setBody($mt->getOutput());
	}
	
	/**
	 * 
	 * @param string $type
	 * @param array $args
	 */
	public function addPart($type, $args)
	{
		$this->innerMsg->addPart($type, $args);
	}
	
	/**
	 * 
	 * @param string $type e.g. Message::SYSTEM_GENERATED
	 */
	public function setSenderType($type)
	{
		$this->innerMsg->setSenderType($type);
	}
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $val
	 */
	public function addSenderArg($name, $val)
	{
		$this->innerMsg->addSenderArg($name, $val);
	}
	
	/**
	 * send this message
	 * @return this message after it has been saved
	 */
	public function send()
	{
		return $this->innerMsg->send();
	}
}