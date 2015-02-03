<?php 
$formdata = $data->form? $data->form : new DataObject();
$formerror = $data->errors? $data->errors: new DataObject();
?>
<div>
	<p>
	You can <a href="<?= $data->paperBaseUrl?>/download">download the paper here</a>. Use the form below
	to submit your comments and recommendations.
	</p>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Review Paper</h4>
		</div>
		<div class="panel-body">
			<form class="form-vertical" method="post" action="<?= $data->paperBaseUrl ?>/review">
				<fieldset>
					<legend>Comments for secretariate</legend>
					<span class="help-block">These comments will not be visible to the author</span>
					<div class="form-group">
						<label>Comments for the secretariate</label>
						<textarea class="form-control" name="comments" rows="7" placeholder="These comments will not be visible to the author"><?php 
							escape($formdata->comments)
						?></textarea>
						<span class="form-error help-block"><?= $formerror->comments ?></span>
					</div>
					or
					<div class="form-group">
						<label>Upload detailed comments (not visible to author)</label>
						<input type="file" name="file">
						<span class="form-error help-block"><?= $formerror->file ?></span>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Comments for researcher</legend>
					<span class="help-block">These comments will be visible to the author</span>
					<div class="form-group">
						<textarea class="form-control" name="author-comments" rows="7" placeholder="Enter comments"><?=
							escape($formdata->get("author-comments"));
						?></textarea>
						<span class="form-error help-block"><?= $formerror->get("author-comments")?></span>
					</div>
					or
					<div class="form-group">
						<label>Upload detailed comments (visible to author)</label>
						<input type="file" name="author-file">
						<span class="form-error help-block"><?= $formerror->get("author-file")?></span>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Recommendation</legend>
					<div class="form-group">
						<?php 
						$options = [
							Review::VERDICT_APPROVED => "Approved",
							Review::VERDICT_REVISION_MIN => "Minor Revision",
							Review::VERDICT_REVISION_MAJ => "Major Revision"
							];
						?>
						<select name="recommendation" class="form-control" required>
							<option value="">Select Recommendation Option</option>
							<?php foreach($options as $option => $value){
								$selected = $formdata->recommendation == $option? "selected" : "";
								?>
							<option value="<?=$option?>" <?=$selected?>><?= $value ?></option>
							<?php }?>
						</select>
						<span class="form-error help-block"><?= $formerror->recommendation ?></span>
					</div>
				</fieldset>
				
				
				<div class="form-group">
					<button class="btn btn-success">Submit</button>
				</div>
				
			</form>
		</div>
	</div>
</div>