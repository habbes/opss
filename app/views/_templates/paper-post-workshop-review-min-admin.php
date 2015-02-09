<?php 
$formdata = $data->postWorkshopReviewMinForm or $formdata = new DataObject();
$formerror = $data->postWorkshopReviewMinErrors or $formerror = new DataObject();
?>
<div>
	<p>
	The paper has been resubmitted after a minor revision from the researcher.
	</p>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Enter review comments</h4>
		</div>
		<div class="panel-body">
			<form enctype="multipart/form-data" method="post" action="<?= $data->paperBaseUrl?>/post-workshop-review-min" >
				<div class="form-group">
					<select class="form-control" name="verdict">
						<option value="">Select conclusion</option>
						<?php foreach(PostWorkshopReviewMin::getVerdicts() as $verdict){?>
						<option value="<?= $verdict?>"><?= PostWorkshopReviewMin::getVerdictString($verdict)?></option>
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
	
</div>