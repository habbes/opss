<?php

$ds = DIRECTORY_SEPARATOR;
require_once __DIR__ . "{$ds}Swift{$ds}lib{$ds}swift_required.php";

class Mailer
{
	
	/**
	 * @var Swift_Mailer
	 */
	private static $instance;
	
	/**
	 * @var string
	 */
	private static $fromEmail;
	
	/**
	 * @var string
	 */
	private static $fromName;
	
	private function __construct(){}
	
	private static function mailerFromConfig()
	{
		$ds = DIRECTORY_SEPARATOR;
		require_once DIR_CORE.$ds."Swift".$ds."lib".$ds."swift_required.php";
		$host = Config::smtp("host");
		$port = Config::smtp("port");
		$security = Config::smtp("security");
		$uname = Config::smtp("uname");
		$password = Config::smtp("pass");
		$from = Config::smtp("from");
		$fromName = Config::smtp("from_name");
		$transport = Swift_SmtpTransport::newInstance($host, $port, $security);
		$transport->setUsername($uname);
		$transport->setPassword($password);
		$mailer = Swift_Mailer::newInstance($transport);
		
		self::$fromEmail = $from;
		self::$fromName = $fromName;
		return $mailer;
	}
	
	/**
	 * the working instance of this class
	 * @return Swift_Mailer
	 */
	public static function getInstance()
	{
		if(!self::$instance){
			self::$instance = self::mailerFromConfig();
		}
		return self::$instance;
	}
	
	/**
	 * gets an instance of the Message class used for building emails
	 * @return Swift_Message
	 */
	public static function getMessageInstance()
	{
		return new Swift_Message();
	}
	
	public static function setFromEmail($email)
	{
		self::$fromEmail = $email;
	}
	
	public static function getFromName()
	{
		return self::$fromName;
	}
	
	public static function setFromName($name)
	{
		self::$fromName = $name;
	}
	
	public static function restoreDefaultValues()
	{
		self::$fromEmail = Config::smtp("from");
		self::$fromName = Config::smtp("from_name");
	}
	
	/**
	 * 
	 * @param Swift_Message $msg
	 * @return number number of successful emails
	 */
	public static function send($msg)
	{
		$mailer = self::getInstance();
		$msg->setFrom([self::$fromEmail => self::$fromName]);
		return $mailer->send($msg);
	}
	
	/**
	 * sends an email with html content as body
	 * @param string $email
	 * @param string $name
	 * @param string $subject
	 * @param string $htmlbody
	 * @param string $textbody the alternative text to display if the client does support html,
	 * if this is not provided, a text version will be generated from stripping the tags off the html
	 * @return number|boolean
	 */
	public static function sendHtml($email, $name, $subject, $htmlbody, $textbody="")
	{
		$mailer = self::getInstance();
		$msg = Swift_Message::newInstance($subject);
		$msg->setTo([$email]);
		$msg->setBody($htmlbody, "text/html");
		
		if(empty($textbody)){
			$textbody = html_entity_decode(strip_tags($htmlbody));
		}
		
		$msg->addPart($textbody, "text/plain");
		
		try {
			return self::send($msg);
		}
		catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}
	
	
}