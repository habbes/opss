<div>
	<div class="history-list">
	<?php 
	foreach ($this->data->paper->getChanges() as $change){
			$time = Utils::siteDateTimeFormat($change->getDate());
			switch($change->getAction()){
							
			case PaperChange::ACTION_SUBMITTED:
			case PaperChange::ACTION_RESUBMITTED:
					if($change->getAction() == PaperChange::ACTION_SUBMITTED)
						$changeTitle = "Submitted to OPSS";
					else
						$changeTitle = "Resubmitted after Revision";
					$authors = "";
					//TODO: hiding author details needs to be refactored, see also AUTHOR_ADDED event
					if($data->user->getRole()->canViewPaperAuthor()){
						foreach ($change->getArg('authors',[]) as $author){
							$authors .= "{$author->name} ({$author->email})<br>";
						}
						if(!$authors)
							$authors = "<i>none</i>";
					}
					
					$changeDetails =<<<DETAILS
					<b>Title</b><br>
						{$change->getArg('title')}<br>
					<b>Date Resubmitted</b><br>
						{$change->getArg('dateSubmitted')}<br>
					<b>Country of research</b><br>
						{$change->getArg('country')}<br>
					<b>Co-authors</b><br>
						$authors<br>
					<b>Paper</b><br>
						<span class="glyphicon glyphicon-download"></span>
							<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/version/{$change->getId()}">Download Paper</a>
					<br><b>Cover</b><br>
						<span class="glyphicon glyphicon-download"></span>
							<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/cover/version/{$change->getId()}">Download Cover</a>
DETAILS;
		
			break;
		case PaperChange::ACTION_VETTED:
			$changeTitle = "Vetted";
			$vetReview = VetReview::findById($change->getArg("vetReviewId"));
			$changeDetails =<<<DETAILS
					<b>Verdict</b><br>
						{$vetReview->getVerdict()}<br>
					<b>Comments</b><br>
						<p>
						{$vetReview->getComments()}
						</p>
DETAILS;
			break; 
		case PaperChange::ACTION_TITLE_CHANGED:
		case PaperChange::ACTION_LANGUAGE_CHANGED:
		case PaperChange::ACTION_COUNTRY_CHANGED:
			$action = $change->getAction();
			if($action == PaperChange::ACTION_TITLE_CHANGED)
				$changeTitle = "Title Changed";
			else if($action == PaperChange::ACTION_LANGUAGE_CHANGED)
				$changeTitle = "Language Changed";
			else
				$changeTitle = "Country Changed";
			$changeTitle = "Title changed";
			$changeDetails =<<<DETAILS
					<b>From</b><br>
						{$change->getArg('from')}<br>
					<b>To</b><br>
						{$change->getArg('to')}<br>
DETAILS;
			 break;
		case PaperChange::ACTION_AUTHOR_ADDED:
			if($data->user->getRole()->canViewPaperAuthor()){
				$changeTitle = "Author Added";
				$changeDetails =<<<DETAILS
					<b>Name</b><br>
						{$change->getArg('name')} ({$change->getArg('email')})<br>
					<b>Reasons</b><br>
						{$change->getArg('reasons')}<br>
DETAILS;
			}
			break;
		case PaperChange::ACTION_FILE_CHANGED:
			$changeTitle = "Document Changed";
			$changeDetails =<<<DETAILS
			<span class="glyphicon glyphicon-download"></span>
			<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/version/{$change->getId()}">Download Paper</a>
DETAILS;
			break;
		case PaperChange::ACTION_COVER_CHANGED:
			$changeTitle = "Cover Changed";
			$changeDetails =<<<DETAILS
			<span class="glyphicon glyphicon-download"></span>
			<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/cover/version/{$change->getId()}">Download Cover</a>
DETAILS;
			break;
		default:
			$changeTitle = $change->getAction();
			$changeDetails = "";
						
		}?>
		<div class="panel panel-default history-item">
		<div class="panel-heading">
		<span class="history-date"><?= $time?></span> -
						<span class="history-title font-bold"><?= $changeTitle?></span>
					</div>
					<div class="panel-body">
						<?= $changeDetails ?>
					</div>
				</div>
	<?php } ?>
		
	</div>
</div>