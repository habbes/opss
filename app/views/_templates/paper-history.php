<div>
	<div class="history-list">
	<?php 
	foreach ($this->data->paper->getChanges() as $change){
			switch($change->getAction()){
				case PaperChange::ACTION_SUBMITTED:
					$time = Utils::siteDateTimeFormat($change->getDate());
					$authors = [];
					foreach ($change->getArg('authors',[]) as $author){
						array_push($authors, (array)$author);
					}
					if(count($authors) == 1)
						$authors[1] = ["name"=>"","email"=>""];
					if(count($authors) <= 0){
						$authors[0] = ['name'=>'','email'=>''];
						$authors[1] = ['name'=>'','email'=>''];
					}
					$changeTitle = "Submitted to OPSS";
					$changeDetails =<<<DETAILS
					<b>Title</b><br>
						{$change->getArg('title')}<br>
					<b>Language of paper</b><br>
						{$change->getArg('language')}<br>
					<b>Country of research</b><br>
						{$change->getArg('country')}<br>
					<b>Co-authors</b><br>
						{$authors[0]['name']}  ({$authors[0]['email']})<br>
						{$authors[1]['name']}  ({$authors[1]['email']})<br>
					<b>Paper</b><br>
						<span class="glyphicon glyphicon-download"></span>
								<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/version/{$change->getId()}">Download Paper</a>
DETAILS;
					?>
		<div class="panel panel-default history-item">
			<div class="panel-heading">
				<span class="history-date"><?= $time?></span> -
				<span class="history-title font-bold"><?= $changeTitle?></span>
			</div>
			<div class="panel-body">
				<?= $changeDetails ?>
			</div>
		</div>
					<?php break; ?>	
			<?php 				
			case PaperChange::ACTION_RESUBMITTED:
					$time = Utils::siteDateTimeFormat($change->getDate());
					$authors = [];
					foreach ($change->getArg('authors',[]) as $author){
						array_push($authors, (array)$author);
					}
					if(count($authors) == 1)
						$authors[1] = ["name"=>"","email"=>""];
					if(count($authors) <= 0){
						$authors[0] = ['name'=>'','email'=>''];
						$authors[1] = ['name'=>'','email'=>''];
					}
					$changeTitle = "Resubmitted to OPSS";
					$changeDetails =<<<DETAILS
					<b>Title</b><br>
						{$change->getArg('title')}<br>
					<b>Date Resubmitted</b><br>
						{$change->getArg('dateSubmitted')}<br>
					<b>Country of research</b><br>
						{$change->getArg('country')}<br>
					<b>Co-authors</b><br>
						{$authors[0]['name']}  ({$authors[0]['email']})<br>
						{$authors[1]['name']}  ({$authors[1]['email']})<br>
					<b>Paper</b><br>
						<span class="glyphicon glyphicon-download"></span>
							<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/version/{$change->getId()}">Download Paper</a>
					<br><b>Cover</b><br>
						<span class="glyphicon glyphicon-download"></span>
							<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/cover/version/{$change->getId()}">Download Cover</a>
DETAILS;
					?>
		<div class="panel panel-default history-item">
			<div class="panel-heading">
				<span class="history-date"><?= $time?></span> -
				<span class="history-title font-bold"><?= $changeTitle?></span>
			</div>
			<div class="panel-body">
				<?= $changeDetails ?>
			</div>
		</div>
				<?php break; ?>			
		<?php
		case PaperChange::ACTION_VETTED:
			$time = Utils::siteDateTimeFormat($change->getDate());
			$authors = [];
			foreach ($change->getArg('authors',[]) as $author){
				array_push($authors, (array)$author);
			}
			if(count($authors) == 1)
				$authors[1] = ["name"=>"","email"=>""];
			if(count($authors) <= 0){
				$authors[0] = ['name'=>'','email'=>''];
				$authors[1] = ['name'=>'','email'=>''];
			}
			$changeTitle = "Vetted to OPSS";
			$vetReview = VetReview::findById($change->getArg("vetReviewId"));
			$changeDetails =<<<DETAILS
					<b>Verdict</b><br>
						{$vetReview->getVerdict()}
					<b>Comments</b><br>
						{$vetReview->getComments()}
					<b>Co-authors</b><br>
						{$authors[0]['name']}  ({$authors[0]['email']})<br>
						{$authors[1]['name']}  ({$authors[1]['email']})<br>
					<b>Paper</b><br>
						<span class="glyphicon glyphicon-download"></span>
							<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/{$data->paper->getId()}">Download Paper</a>
DETAILS;
								?>
				<div class="panel panel-default history-item">
					<div class="panel-heading">
						<span class="history-date"><?= $time?></span> -
						<span class="history-title font-bold"><?= $changeTitle?></span>
					</div>
					<div class="panel-body">
						<?= $changeDetails ?>
					</div>
				</div>
							<?php break; ?>
		<?php 
		case PaperChange::ACTION_TITLE_CHANGED:
			$time = Utils::siteDateTimeFormat($change->getDate());
			$authors = [];
			foreach ($change->getArg('authors',[]) as $author){
				array_push($authors, (array)$author);
			}
			if(count($authors) == 1)
				$authors[1] = ["name"=>"","email"=>""];
			if(count($authors) <= 0){
				$authors[0] = ['name'=>'','email'=>''];
				$authors[1] = ['name'=>'','email'=>''];
			}
			$changeTitle = "Title changed";
			$changeDetails =<<<DETAILS
					<b>From</b><br>
						{$change->getArg('from')}<br>
					<b>To</b><br>
						{$change->getArg('to')}<br>
					<b>Co-authors</b><br>
						{$authors[0]['name']}  ({$authors[0]['email']})<br>
						{$authors[1]['name']}  ({$authors[1]['email']})<br>
					<b>Paper</b><br>
						<span class="glyphicon glyphicon-download"></span>
							<a class="link" role="button" href="{$data->paper->getAbsoluteUrl()}/download/{$data->paper->getId()}">Download Paper</a>
DETAILS;
								?>
				<div class="panel panel-default history-item">
					<div class="panel-heading">
						<span class="history-date"><?= $time?></span> -
						<span class="history-title font-bold"><?= $changeTitle?></span>
					</div>
					<div class="panel-body">
						<?= $changeDetails ?>
					</div>
				</div>
							<?php break; ?>	
		<?php } 
			} ?>
	</div>
</div>