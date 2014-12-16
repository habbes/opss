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
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = self::mailerFromConfig();
		}
		return self::$instance;
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
	
	public static function sendHtml($email, $name, $subject, $htmlbody, $textbody="")
	{
		$mailer = self::getInstance();
		$msg = Swift_Message::newInstance($subject);
		$msg->setTo([$email]);
		$msg->setBody($htmlbody, "text/html");
		$msg->setFrom([self::$fromEmail => self::$fromName]);
		
		if(empty($textbody)){
			$textbody = html_entity_decode(strip_tags($htmlbody));
		}
		
		$msg->addPart($textbody, "text/plain");
		
		try {
			return $mailer->send($msg);
		}
		catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}
	
}