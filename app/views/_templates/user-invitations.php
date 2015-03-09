<?php
$formdata = $data->form or $formdata = new DataObject();
$formerror = $data->errors or $formerror = new DataObject();
?>
<div>
	<div class="col-sm-6">
		<h4>Invite User</h4>
		<form class="form-vertical" method="post" >
			<div class="form-group">
				<select class="form-control" name="type" required>
					<?php foreach($data->userTypes as $type => $string) {
						$selected = $type == $formdata->type? "selected" : "";
					?>
					<option value="<?=$type?>" <?= $selected?>><?= $string ?></option>
					<?php } ?>
				</select>
				<span class="form-error text-danger"><?= $formerror->type ?></span>
			</div>
			<div class="form-group">
				<input class="form-control" type="email" name="email" value="<?= $formdata->email?>" placeholder="Enter email" required/>
				<span class="form-error text-danger"><?= $formerror->email ?></span>
			</div>
			<div class="form-group">
				<input class="form-control" type="email" name="confirm-email" value="<?= $formdata->get("confirm-email")?>" 
				placeholder="Repeat email" required />
				<span class="form-error text-danger"><?= $formerror->get("confirm-email") ?></span>
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="name" value="<?= $formdata->name?>" 
				placeholder="Enter name" required />
				<span class="form-error text-danger"><?= $formerror->name ?></span>
			</div>
			<div class="form-group">
				<input class="btn btn-success" type="submit" value="Send Invitation"/>
			</div>
		</form>
	</div>
	<div class="col-sm-6">
		<h4>Pending Invitations</h4>
	</div>
</div>