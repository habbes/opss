<?php 
$formdata = $data->form? $data->form : new DataObject();
$formerror = $data->errors? $data->errors : new DataObject();
?>
<div>
	<?php if(count($data->requests) == 0) { ?>
	<p>No pending requests found.</p>
	<?php } else {?>
	<div class="panel-group" id="request-list" role="tablist" aria-multiselectable="true">
		<?php foreach($data->requests as $request) { 
			$requestId = "request-".$request->getId();
			$selected = $data->selectedRequest? $request->getId() == $data->selectedRequest->getId() : false;
		?>
		<div class="panel panel-default" id="<?= $requestId?>">
			<div class="panel-heading" role="tab" id="<?=$requestId?>-heading">
				<h4 class="panel-title">
					<a class="<?= $selected? "":"collapsed"?>" data-toggle="collapse" data-parent="#request-list" 
					href="<?="#". $requestId?>-body"
						aria-expanded="true" aria-controls="<?= $requestId?>-body">
					<?= $request->getPaper()->getTitle() ?> (<?= $request->getPaper()->getIdentifier()?>)
					</a>
				</h4>
			</div>
			<div id="<?= $requestId?>-body" class="panel-collapse collapse <?= $selected? "in" : ""?>" 
				role="tabpanel" aria-labelledby="<?=$requestId?>-heading">
				<div class="panel-body">
					<span>Sent on <?= Utils::siteDateTimeFormat($request->getDateSent())?></span><br>
					<?php if(!$request->isPermanent()) {?>
					<span>Expires on <?= Utils::siteDateFormat($request->getExpiryDate())?></span><br>
					<?php } ?>
					<span>Payment: $<?= $request->getPayment() ?></span><br>
					<a class="link" href="<?= $request->getAbsoluteUrl()."/download-paper"?>" ><span class="glyphicon glyphicon-download"></span> Download Paper</a><br>
					
					<form method="post" action="<?=URL_PAPERS?>/review-requests/<?= $request->getId()?>">
						<span class="form-error help-block"><?= $selected? $formerror->action : ""?></span>
						<div class="form-group">
							<button class="btn btn-default" name="accept">Accept Request
							<span class="glyphicon glyphicon-ok text-success"></span>
							</button>
							<button class="btn btn-default" name="decline">Decline
							<span class="glyphicon glyphicon-remove text-danger"></span>
							</button>
						</div>
						<div class="form-group">
							<textarea class="form-control" cols="" rows="5" placeholder="Enter comments if you decline" 
							name="comments"><?= $selected? $formdata->comments : ""?></textarea>
						</div>
						
					</form>
				</div>
			</div>
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>