<?php

/**
 * represents a file saved from a user upload or one dynamically generated by the system
 * @author Habbes
 *
 */
class File extends DBModel
{
	
	const DIR = DIR_DATA;
	
	//db properties
	protected $filename;
	protected $inner_filename;
	protected $directory;
	protected $filetype;
	
	//non-db properties
	private $_size = -1;
	private $_content = "";
	
	/**
	 * creates a file and saves it both in the filesystem and in the database
	 * Note: this relies on the FILEINFO filetype to detect the files mime type
	 * On windows, include bundled php_fileinfo.dll in php.ini to enable this extension
	 * @param string $filename
	 * @param string $directory
	 * @param string $sourcePath
	 * @param string $fromUpload
	 * @return DBModel
	 */
	public static function create($filename, $directory, $sourcePath, $fromUpload = true)
	{
		//get mime file type
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$file = new static();
		$file->filetype = $finfo->file($sourcePath);
		$file->directory = $directory;
		$file->filename = $filename;
		$ds = DIRECTORY_SEPARATOR;
		$file->inner_filename = Utils::uniqueFilename($file->directory, $ds);
		
		//create directory if it doesn't exits
		if(!file_exists($file->getDirectory())){
			mkdir($file->getDirectory(), $recursive = true);
		}
		
		//move or copy depending on whether or not the file is from upload
		if($fromUpload){
			$result = move_uploaded_file($sourcePath, $file->getFilepath());
		} else {
			$result = copy($sourcepath, $file->getFilepath());
		}
		
		if(!$result) return null;
		
		return $file->save();
	}
	
	/**
	* create a file from an uplaoad
	* Note: this relies on the FILEINFO filetype to detect the files mime type
	* On windows, include bundled php_fileinfo.dll in php.ini to enable this extension
	* @param string $filename
	* @param string $directory
	* @param string $tempname
	* @return File on success the created instance is returned otherwise null is returned
	* 
	*/
	public static function createFromUpload($filename, $directory, $tempname)
	{
		return static::create($filename, $directory, $tempname, true);
	}
	
	/**
	 * get the absolute path of the directory that contains the file
	 * @return string
	 */
	public function getDirectory()
	{
		$ds = DIRECTORY_SEPARATOR;
		return self::DIR.$ds.$this->directory;
	}
	
	/**
	 * get the absolute path of the file's location
	 * @return string
	 */
	public function getFilepath()
	{
		$ds = DIRECTORY_SEPARATOR;
		return $this->getDirectory().$ds.$this->inner_filename;
	}
	
	public function getSize()
	{
		if($this->_size < 1){
			$this->_size = count($this->getContent());
		}
		return $this->_size;			
	}
	
	/**
	 * gets the content of the file
	 * @return string
	 */
	public function getContent()
	{
		if(!$this->_content){
			$this->_content = file_get_contents($this->getFilepath());
		}
		return $this->_content;
	}
	
	/**
	 * echos the content of the file
	 */
	public function outputContent()
	{
		readfile($this->getFilepath());
	}
	
	/**
	 * sends the content of this file as a response to the user, allowing them to download this file
	 */
	public function sendResponse()
	{
		Utils::sendFileResponse($this->getFilepath(), $this->getFilename());
	}
	
	
	protected function onDelete()
	{
		//deletes the actual file before the entry is removed from the database
		unlink($this->getFilepath());
		return true;
	}
	
	protected function validate(array &$errors)
	{
		if(!file_exists($this->getFilepath()))
			return false;
		
		return true;
	}
	
	
	
}