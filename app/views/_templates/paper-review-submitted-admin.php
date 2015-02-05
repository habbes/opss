<?php 

$reviewer = $data->reviewer;
$review = $data->review;
$formdata = $data->reviewSubmittedForm or $formdata = new DataObject();
$formerror = $data->reviewSubmittedErrors or $formerror = new DataObject();
?>
<div>
	<p>
		This paper has been reviewed by <?= escape($data->reviewer->getFullName()) ?>. Here are the details and recommendations from the review.
	</p>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Review from <?= escape($data->reviewer->getFullName()) ?></h4>
		</div>
		<div class="panel-body">
			<h5><b>Recommendation</b></h5>
			<div><?= Review::getVerdictString($data->review->getRecommendation())?></div>
			<h5><b>Comments for secretariate</b></h5>
			<?php if($review->hasFileToAdmin()){?>
			<div class="font-bold">
				The reviewer has provided comments in
				<a class="link" href="<?= $data->paperBaseUrl?>/review-submitted/file-admin">this file</a>.
			</div>
			<br>
			<?php } ?>
			<div><?= escape($data->review->getCommentsToAdmin()) ?></div>
			<h5><b>Comments for researcher</b></h5>
			<?php if($review->hasFileToAuthor()){?>
			<div class="font-bold">
				The reviewer has provided comments in
				<a class="link" href="<?= $data->paperBaseUrl?>/review-submitted/file-author">this file</a>.
			</div>
			<br>
			<?php } ?>
			<div><?= escape($data->review->getCommentsToAuthor())?></div>
		</div>
		
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">Forward to researcher</h4>
		</div>
		<div class="panel-body">
			<form method="post" action="<?= $data->paperBaseUrl?>/review-submitted" enctype="multipart/form-data">
				<div class="form-group">
					<?php 
					$options = [];
					foreach(Review::getAdminVerdicts() as $option){
						$options[$option] = Review::getVerdictString($option);
					}
					
					?>
					<select class="form-control" name="verdict" required>
						<option value="">Select Verdict</option>
						<?php foreach($options as $option => $value) {
							$selected = $formdata->verdict == $option? "selected" : "";
						?>
						<option value="<?= $option ?>"><?= $value ?></option>
						<?php }?>
					</select>
					<span class="form-error help-block"><?= $formerror->verdict ?></span>
				</div>
				<div class="form-group">
					<?php 
					$postComments = "checked";
					if($formdata->get("post-comments") === "false")
						$postComments = "";
					?>
					<input type="checkbox" name="post-comments" <?= $postComments ?>/> Allow researcher to see comments from reviewer<br>
				</div>
				<div class="form-group">
					<textarea class="form-control" name="comments" rows="6"
					placeholder="Enter your comments for the researcher"><?= escape($formdata->comments)?></textarea>
					<span class="form-error help-block"><?= $formerror->comments ?></span>
				</div>
				<span class="big">alternatively, upload file with comments</span>
				<div class="form-group">
					<div>
						<input type="file" name="file"/>
						<span class="form-error help-block"><?= $formerror->file ?></span>
					</div>
				</div>
				<div class="form-group">
					<button class="btn btn-default">Forward to Researcher</button>
				</div>
			</form>
		</div>
	</div>

</div>