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
						<textarea class="form-control" name="comments" rows="7" placeholder="These comments will not be visible to the author"></textarea>
						<span class="form-error help-block"></span>
					</div>
					or
					<div class="form-group">
						<label>Upload detailed comments (visible to author)</label>
						<input type="file" name="file">
						<span class="form-error help-block"></span>
					</div>
				</fieldset>
				
				<fieldset>
					<legend>Comments for researcher</legend>
					<span class="help-block">These comments will be visible to the author</span>
					<div class="form-group">
						<textarea class="form-control" name="researcher-comments" rows="7" placeholder="Enter comments"></textarea>
						<span class="form-error help-block"></span>
					</div>
					or
					<div class="form-group">
						<label>Upload detailed comments (not visible to author)</label>
						<input type="file" name="researcher-file">
						<span class="form-error help-block"></span>
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
						<select class="form-control">
							<option value="">Select Recommendation Option</option>
							<?php foreach($options as $option => $value){?>
							<option value="<?=$option?>"><?= $value ?></option>
							<?php }?>
						</select>
					</div>
				</fieldset>
				
				
				<div class="form-group">
					<button class="btn btn-success">Submit</button>
				</div>
				
			</form>
		</div>
	</div>
</div>