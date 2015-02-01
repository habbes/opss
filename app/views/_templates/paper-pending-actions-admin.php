<div>
	<p>
		Choose a course of action below.
	</p>
	<div class="" role="tablist" id="pending-actions-list">
	<?php foreach($data->paper->getNextActions() as $action){
		switch($action){
		 case Paper::ACTION_EXTERNAL_REVIEW: 
		 	
		 	$formdata = $data->reviewRequestForm? $data->reviewRequestForm : new DataObject();
		 	$formerror = $data->reviewRequestErrors? $data->reviewRequestErrors : new DataObject();

		 	?>
		 	<div class="panel panel-default">
		 		<div class="panel-heading">
		 			<h4 class="panel-title">Invite existing reviewer to review paper</h4>
		 		</div>
		 		<div class="panel-body">
		 			<form class="form" method="post" action="<?= $data->paperBaseUrl?>/review-request">
		 				<div class="form-group">
		 					<select class="form-control" name="reviewer" required>
		 						<option value="">Select reviewer</option>
		 						<?php foreach($this->data->reviewers as $reviewer){
		 							$selected = $reviewer->getId() == $formdata->reviewer? "selected" : "";
		 						?>
		 						<option value="<?= $reviewer->getId()?>"><?= $reviewer->getFullName()?>
		 						(currently reviewing <?= $reviewer->getRole()->countPapers() ?> papers)</option>
		 						<?php } ?>
		 					</select>
		 					<span class="form-error help-block"><?= $formerror->reviewer ?></span>
		 				</div>
		 				<div class="form-group">
		 					<button class="btn btn-default" >Send Invitation</button>
		 				</div>
		 			</form>
		 		</div>
		 	</div>
		 	<?php 
		 	$formdata = $data->inviteReviewerForm? $data->inviteReviewerForm : new DataObject();
		 	$formerror = $data->inviteReviewerErrors? $data->inviteReviewerErrors : new DataObject();
		 	?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">Invite external reviewer to review paper</h4>
				</div>
				<div class="panel-body">
					<form class="form" method="post" action="<?= $data->paperBaseUrl?>/invite-reviewer" >
						<div class="form-group">
							<input type="email" name="email" class="form-control" placeholder="Email" value="<?= $formdata->email ?>">
							<span class="form-error help-block"><?= $formerror->email ?></span>
						</div>
						<div class="form-group">
							<input type="email" name="confirm-email" class="form-control" placeholder="Confirm email" 
								value="<?= $formdata->get("confirm-email") ?>">
							<span class="form-error help-block"><?= $formerror->get("confirm-email") ?></span>
						</div>
						<div class="form-group">
							<input type="text" name="name" class="form-control" placeholder="Name" value="<?= $formdata->name ?>">
							<span class="form-error help-block"><?= $formerror->name ?></span>
						</div>
						<div class="form-group">
							<button class="btn btn-default">Send Invitation</button>
						</div>
					</form>
				</div>
			</div>
	
		<?php break;?>
		
	<?php } 
	}?>
	</div>
</div>