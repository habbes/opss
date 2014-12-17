<?php

class TestHandler extends RequestHandler
{
	private function showPage()
	{
		$this->viewParams->files = File::findAll();
		$this->renderView("Test");
	}
	public function get($id = null)
	{
		if($id){
			$file = File::findById((int) $id);
			$file->sendResponse();
		}
		
		$this->showPage();
	}
	
	public function post()
	{
		
		$file = $this->fileVar("file");
		$name = $file->name;
		$path = $file->tmp_name;
		$directory = "test";
		try
		{
			$file = File::createFromUpload($name, $directory, $path);
		}
		catch(ValidationException $e)
		{
			
		}
		catch(Exception $e)
		{
			
		}
		
		$this->showPage();
	}
}