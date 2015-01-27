
<div>
	<p>
		This paper is waiting to be vetted. You can <u><a class="link" href="<?= $data->paperBaseUrl ?>/download">download the paper here</a></u>.
		When you are ready to complete vetting this paper, use the form below to enter your verdict.
	</p>
	<div>
		<h4>Vet this paper</h4>
		<form method="post" action="<?= $data->paperBaseUrl ?>/vet" id="vet-review-form">
			<div class="form-group">
				<select name="group" class="form-control">
					<option value="">Select group for this paper</option>
					<?php foreach(PaperGroup::getValues() as $group => $name) { 
						$selected = $data->form->group == $group? "selected" : "";
					?>
					<option value="<?=$group?>" <?= $selected?> ><?= $name ?></option>
					<?php } ?>
				</select>
				<span class="form-error help-block"><?= $data->errors->group ?></span>
			</div>
			<div class="form-group">
				<label>Comments</label>
				<textarea name="comments" class="form-control" rows="7" id="comments" placeholder="Enter comments"><?= escape($data->form->comments) ?></textarea>
				<span class="form-error"><?= $data->errors->comments?></span>
			</div>
			<div class="form-group">
				<button class="btn" type="submit" name="<?= VetReview::VERDICT_ACCEPTED ?>">Accept Proposal
				<span class="glyphicon glyphicon-ok text-success"></span></button> or 
				<button class="btn" type="submit" name="<?= VetReview::VERDICT_REJECTED ?>">Send Proposal back to Researcher 
				<span class="glyphicon glyphicon-remove text-danger"></span></button>
				<span class="form-error help-block"><?= $data->errors->verdict ?></span>
			</div>
		</form>
	</div>
</div>