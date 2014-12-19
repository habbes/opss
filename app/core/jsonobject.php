<?php

/**
 * creates dyanmic objects that could be encoded into json or decoded from json
 * @author Habbes
 *
 */
class JsonObject extends DataObject
{
	
	/**
	 * creats and instance from a json file
	 * @param string $path
	 * @return JsonObject
	 */
	public static function load($path)
	{
		$json = file_get_contents($path);
		return static::decode($json);
	}
	
	/**
	 * creates an instance from a json string
	 * @param string $json
	 * @return JsonObject
	 */
	public static function decode($json)
	{
		$data = json_decode($json, true);
		return new static($data);
	}
	
	/**
	 * returns the json dump of this object
	 * @return string
	 */
	public function encode()
	{
		return json_encode($this->data);
	}
	
	/**
	 * echoes the json representation of this object
	 */
	public function output()
	{
		echo $this->encode();
	}
	
	/**
	 * echoes the json representation of this object and terminates the script
	 */
	public function outputAndExit()
	{
		$this->output();
		exit;
	}
	
	/**
	 * sends the json string of this object as the response to the user
	 */
	public function sendResponse()
	{
		Utils::sendJsonResponse($this);
	}
	
}