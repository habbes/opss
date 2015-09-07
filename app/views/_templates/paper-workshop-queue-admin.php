<?php 
$formdata = $data->workshopReviewForm or $formdata = new DataObject();
$formerror = $data->workshopReviewErrors or $formerror = new DataObject();
?>
<div>
	<p>
	The paper has been added to the workshop scheduled on
	<a class="link" href="<?=$data->workshop->getAbsoluteUrl()?>"><?= $data->workshop->toString()?></a>.
	</p>
	
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Enter workshop review comments</h4>
		</div>
		<div class="panel-body">
			<form enctype="multipart/form-data" method="post" action="<?= $data->paperBaseUrl?>/workshop-review" >
				<div class="form-group">
					<select class="form-control" name="verdict">
						<option value="">Select conclusion</option>
						<?php foreach(WorkshopReview::getVerdicts() as $verdict){?>
						<option value="<?= $verdict?>"><?= WorkshopReview::getVerdictString($verdict)?></option>
						<?php } ?>
					</select>
					<span class="form-error help-block"><?= $formerror->verdict?></span>
				</div>
				<div class="form-group">
					<textarea class="form-control" name="comments" rows="7" placeholder="Enter comments"></textarea>
					<span class="form-error help-block"></span>
				</div>
				<div class="form-group">
					<span>alternatively download comments file</span>
					<input type="file" name="file"/>
					<span class="form-error help-block"></span>
				</div>
				<div class="form-group">
					<button class="btn btn-default">Submit Review</button>
				</div>
			
			</form>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<form method="post" action="<?= $data->paper->getAbsoluteUrl()?>/remove-from-workshop" >
				<div class="form-group" method="post">
					<button class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Remove paper from queue</button>
				</div>
			</form>
		</div>
	</div>
</div>