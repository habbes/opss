<?php

/**
 * class used to fetch an array from
 * a list file stored in sys_data
 * @author Habbes
 *
 */
class SysDataList
{
	
	const DIR = DIR_SYS_DATA;
	
	public static function get($listName)
	{
		$ds = DIRECTORY_SEPARATOR;
		$path = self::DIR.$ds.$listName;
		$list = file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
		return $list;
	}
}