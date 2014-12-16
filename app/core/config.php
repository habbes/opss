<?php

/**
 * Gives access to config data
 * @author Habbes
 *
 */
class Config
{
	
	/**
	 * contains the list of config settings as set in the config/config.php file
	 * @var array
	 */
	private static $config = null;
	
	/**
	 * loads the config file and stores in the $config variable
	 * @return array reutrns the $config variable for convenience
	 */
	private static function loadConfig(){
		if(!self::$config){
			require_once DIR_CONFIG . DIRECTORY_SEPARATOR . "config.php";
			self::$config = $config;
		}
		
		return self::$config;
	}
	
	/**
	 * allows config sections to be called as methods and the keys to be passed as arguments.
	 * Thus it returns the value of the key passed in the argument of the section called as the method
	 * @param string $name
	 * @param array $arguments
	 * @return string
	 */
	public static function __callStatic($name, $arguments)
	{
		$key = empty($arguments)? null : $argumets[0];
		return self::getConfigValue($name, $key);
	}
	
	/**
	 * gets the list of config settings for in the given config sections
	 * @param string $section
	 * @param string $default return value when the setting is not found in config
	 * @return array
	 */
	public static function getConfig($section, $default = null){
		self::loadConfig();
		return array_key_exists($section, self::$config)? self::$config[$section] : $default;
	}
	
	/**
	 * gets the config value of the given key in the given section
	 * @param string $section
	 * @param string $key
	 * @param mixed $default returned when the given section or key is not found
	 * @return string
	 */
	public static function getConfigValue($section, $key, $default = null)
	{
		$config = self::getConfig($section);
		if($key == null){
			return $config? $config : $default;
		}
		return $config && array_key_exists($key, $config)? $config[$key] : $default;
	}
	
	
}