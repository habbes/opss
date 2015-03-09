<?php
$formdata = $data->form or $formdata = new DataObject();
$formerror = $data->errors or $formerror = new DataObject();
?>
<div>
	<div class="col-sm-8">
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
	<div class="col-sm-4">
		<h4>Pending Invitations</h4>
		<?php if(count($data->invitations) == 0){?>
		<p>No pending invitations found.</p>
		<?php } else {?>
		<ul class="list-group">
			<?php foreach($data->invitations as $invitation){?>
				<li class="list-group-item">
 					<b>Sent to:</b> <?= escape($invitation->getName())?>, <?= escape($invitation->getEmail()) ?><br>
 					<b>Sent on:</b> <?= Utils::siteDateTimeFormat($invitation->getDateSent())?><br>
 					<b>Expires:</b> <?= Utils::siteDateTimeFormat($invitation->getExpiryDate())?><br>
 					<form class="form" method="post" action="<?=URL_ROOT?>/invitations/manage">
 						<input type="hidden" name="invitation" value="<?= $invitation->getId()?>" >
 						<div class="form-group">
 							<button class="btn btn-default" name="cancel" >Cancel Invitation
 							<span class="glyphicon glyphicon-remove text-danger"></span></button>
 							<button class="btn btn-default" name="resend">Resend Email</button>
 						</div>
 					</form>
 				</li>
			<?php } ?>
		</ul>
		<?php } ?>
	</div>
	<span class="clearfix"></span>
</div>