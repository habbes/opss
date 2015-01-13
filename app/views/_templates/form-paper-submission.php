<?php
$formdata = $data->form;
$formerror = $data->errors;
?>

<div class="form row">
	<form class="form-horizontal" method="post" role="form">
		<input type="hidden" name="action" value="registration"/>
		<!--  first col -->
		<div class="col-sm-6 col-xs-12">
			<div class="form-group">
			<!-- Title -->
				<div class="col-sm-10">
					<label for="title">Title</label>
					<input type="text" id="title" name="title" placeholder="Title of Paper" class="form-control"
						value="<?= escape($formdata->title)?>" required>
					<span class="help-block text-danger form-error" id="title-error"><?= escape($formerror->title) ?></span>
				</div>				
			</div>
			
			<div class="form-group">
			<!-- Main Document -->
				<div class="col-sm-10">
					<label for="document">Main Document</label>
					<input type="file" id="document" name="document" placeholder="Main Document" class="form-control" required>
					<span class="help-block text-danger form-error" id="document-error"><?= escape($formerror->document) ?></span>
				</div>
			</div>
			
			<div class="form-group">
			<!-- Cover -->
				<div class="col-sm-10">
					<label for="cover">Document Cover</label>
					<input type="file" id="cover" name="cover" placeholder="Document Cover" class="form-control" required>
					<span class="help-block text-danger form-error" id="cover-error"><?= escape($formerror->cover) ?></span>
				</div>
			</div>
			
			<div class="form-group">
			<!-- Language -->
				<div class="col-sm-10">
					<label for="language">Language of Paper</label>
					<select class="form-control" id="language" required>
						<option value="">Language of Paper</option>
						<?php foreach($data->languages as $lang) {?>
						<option value="<?= $lang ?>"  <?= $lang == $formdata->language? "selected" : "" ?>><?= $lang ?></option>
						<?php } ?>
					</select>
					<span class="help-block text-danger form-error" id="language-error"><?= escape($formerror->language) ?></span>
				</div>
			</div>
			
			<div class="form-group">
			<!-- Country -->
				<div class="col-sm-10">
					<label for="country">Country of Research</label>
					<select class="form-control" id="country" placeholder="Country of Research" required>
						<option value="">Country of Research</option>
						<?php foreach($data->countries as $country) {?>
						<option value="<?= $country ?>"  <?= $country == $formdata->country? "selected" : "" ?>><?= $country ?></option>
						<?php } ?>
						<span class="help-block text-danger form-error" id="country-error"><?= escape($formerror->country) ?></span>
					</select>
				</div>
			</div>
			
			<fieldset>
				<!-- Co-Authors  -->
				<fieldset>
					<legend>1<sup>st</sup> Co-author</legend>
					<div class="form-group row combined-fields">
						<div class="col-sm-5 combined-fields-item" style="padding-right:0px;" >
							<input type="text" name="author1-name" id="author1-name" 
								placeholder="Name" class="form-control">
							<span class="help-block text-danger form-error" 
								id="author1-name-error"><?= escape($formerror->get("author1-name")) ?></span>
						</div>
						<div class="col-sm-5 combined-fields-item" style="padding-left:0px">
							<input type="email" name="author1-email" id="author1-email" 
								placeholder="Email" class="form-control">
							<span class="help-block text-danger form-error" 
								id="author1-email-error"><?= escape($formerror->get("author1-email")) ?></span>
						</div>
					</div>
					
				</fieldset>
				<fieldset>
					<legend>2<sup>nd</sup> Co-author</legend>
					<div class="form-group row combined-fields">
						<div class="col-sm-5 combined-fields-item" style="padding-right:0px;" >
							<input type="text" name="author2-name" id="author2-name" 
								placeholder="Name" class="form-control">
							<span class="help-block text-danger form-error" 
								id="author2-name-error"><?= escape($formerror->get("author2-name")) ?></span>
						</div>
						<div class="col-sm-5 combined-fields-item" style="padding-left:0px">
							<input type="email" name="author2-email" id="author2-email" 
								placeholder="Email" class="form-control">
							<span class="help-block text-danger form-error" 
								id="author2-email-error"><?= escape($formerror->get("author2-email")) ?></span>
						</div>
					</div>
					
				</fieldset>
			</fieldset>
			
			<div class="form-group">
			<!--  Submit -->
				<div class="col-sm-10">
					<div class="align-center">
						<input type="submit" class="btn btn-success inline" value="Submit Paper"/>
					</div>
				</div>
			</div>
			
			
			
		</div>
		<!--  end first col -->
		<!--  2nd col -->
		<div class="col-sm-6 col-xs-12">
			<h4 class="font-light" >Guidelines on Paper Submission</h4>
			<p>
			Guidelines go here.
			</p>
		</div>
	</form>
</div>