<?php

class PostWorkshopReviewMinHandler extends PaperHandler
{
	public function post()
	{
		try {
			$comments = $this->trimPostVar("comments");
			$file = $this->fileVar("file");
			$verdict = $this->trimPostVar("verdict");
			//TODO check for errors
			$pwreview = PostWorkshopReviewMin::create($this->paper, $this->user);
			$pwreview->setComments($comments);
			if($file->tmp_name)
				$pwreview->setFile($file->name, $file->tmp_name);
			$pwreview->save();
			
			$pwreview = $this->paper->submitPostWorkshopReviewMin($verdict);
			
			//TODO send notifications and emails
			$this->saveResultMessage("Review submitted successfully.", "success");
			$this->paperLocalRedirect();
			
		}
		catch(OperationException $e){
			$this->saveResultMessage("Errors occured.", "error");
			$this->paperLocalRedirect();
		}
	}
}