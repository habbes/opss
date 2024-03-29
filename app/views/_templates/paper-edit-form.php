<?php 
$formdata = $data->form;
$formerror = $data->errors;

$addAuthorForm = $data->addAuthorForm? $data->addAuthorForm : new DataObject();
$addAuthorErrors = $data->addAuthorErrors? $data->addAuthorErrors : new DataObject();
?>
<div class="col-sm-10">
	<div class="">
		<!-- paper details -->
		<h4>Details</h4>
		<form class="form-vertical" method="post" action="<?= $data->paperBaseUrl?>/edit/details" >
			<div class="form-group">
				<label>Title</label>
				<input class="form-control" type="text" name="title" value="<?= escape($formdata->title) ?>">
				<span class="form-error help-block"><?= $formerror->title ?></span>
			</div>
			<div class="form-group">
				<label>Language</label>
				<select class="form-control" type="text" name="language">
					<?php foreach($data->languages as $lang) {
						$selected = $formdata->language == $lang? "selected" : "";
						?>
					<option value="<?= $lang ?>" <?= $selected ?> ><?= $lang ?></option>
					<?php } ?>
				</select>
				<span class="form-error help-block"><?= $formerror->language ?></span>
			</div>
			
			<div class="form-group">
				<label>Country of research</label>
				<select class="form-control" type="text" name="country">
					<?php foreach($data->countries as $country) {
						$selected = $formdata->country == $country? "selected" : "";
						?>
					<option value="<?= $country ?>" <?= $selected ?> ><?= $country ?></option>
					<?php } ?>
				</select>
				<span class="form-error help-block"><?= $formerror->country ?></span>
			</div>
			<div class="form-group">
				<label>Region of research</label>
				<select class="form-control" type="text" name="region">
					<option value="">Select region</option>
					<?php foreach($data->regions as $region) {
						$selected = $formdata->region == $region? "selected" : "";
						?>
					<option value="<?= $region ?>" <?= $selected ?> ><?= $region ?></option>
					<?php } ?>
				</select>
				<span class="form-error help-block"><?= $formerror->region ?></span>
			</div>
			
			<div class="form-group">
				<label>Thematic Area</label>
				<select name="group" class="form-control">
					<option value="">Select thematic area</option>
					<?php foreach(PaperGroup::getValues() as $group => $name) { 
						$selected = $formdata->group == $group? "selected" : "";
					?>
					<option value="<?=$group?>" <?= $selected?> ><?= $name ?></option>
					<?php } ?>
				</select>
				<span class="form-error help-block"><?= $formerror->group ?></span>
			</div>
			
			<div class="form-group">
				<button class="btn btn-default">Save Changes</button>
			</div>
			
		</form>
	</div>
	<!-- end paper details -->
	
	<?php if($data->user->isResearcher()){?>
	<!-- paper files -->
	<div>
		<h4>Files</h4>
		<form class="form-vertical" enctype="multipart/form-data" method="post" action="<?=$data->paperBaseUrl?>/edit/files">
			<div class="form-group">
				<label>Main Document</label>
				<input class="" type="file" name="document">
				<span class="form-error help-block"><?= $formerror->document ?></span>
			</div>
			<div class="form-group">
				<label>Cover</label>
				<input class="" type="file" name="cover">
				<span class="form-error help-block"><?= $formerror->cover ?></span>
			</div>
			<div class="form-group">
				<button class="btn btn-default">Upload and Replace Files</button>
			</div>			
		</form>
		
	</div>
	<!-- end paper details -->
	
	<!--  authors -->
	<div>
		<h4>Co-Authors</h4>
		<div>
			<?php foreach($data->paper->getAuthors() as $author) { ?>
			<div>
				<div>
					<span><?= sprintf("%s (%s)", escape($author->getName()), escape($author->getEmail())) ?></span>
					<a href="#" role="button" class=""><span class="glyphicon glyphicon-remove text-warning"></span></a>
				</div>
				<form style="margin-left:20px" class="form-vertical hidden" method="post">
					<div class="form-group">
						<textarea class="form-control" name="reasons" placeholder="Reasons for removing author"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-default" class="">Remove Author</button>
					</div>
					
				</form>
			</div>
			<?php } ?>
		</div>
		<div>
			<span>Add Author</span>
			<form method="post" action="<?= $data->paperBaseUrl ?>/edit/add-author">
				<div class="form-group row combined-fields">
					<div class="col-sm-6 combined-fields-item" style="padding-right:0px">
						<input class="form-control" type="text" name="name" placeholder="Name" value="<?= $addAuthorForm->name ?>" required>
						<span class="form-error help-block"><?= $addAuthorErrors->name ?></span>
					</div>
					<div class="col-sm-6 combined-fields-item" style="padding-left:0px">
						<input class="form-control" type="email" name="email" value="<?= $addAuthorForm->email ?>" placeholder="Email" required>
						<span class="form-error help-block"><?= $addAuthorErrors->email ?></span>
					</div>
				</div>
				<div class="form-group">
					<textarea class="form-control" name="reasons" placeholder="Reasons for adding author" 
						value="<?= $addAuthorForm->reasons ?>" required></textarea>
					<span class="form-error help-block"><?= $addAuthorErrors->reasons ?></span>
				</div>
				<div class="form-group">
					<button class="btn btn-default">Add Author</button>
					<span class="form-error help-block"><?= $addAuthorErrors->form ?></span>
				</div>
			</form>
		</div>
	</div>
	
	<!-- end authors -->
	<?php } // if($data->user->isResearcher())?>
</div>