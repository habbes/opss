<div>
	<p>
		This paper is currently being reviewed by <strong><?= $data->reviewer->getFullName()?></strong>
		(since <?= Utils::siteDateFormat($data->review->getDateInitiated())?>).
		You will be notified when the reviewer has submitted recommendations.
	</p>
	<p>
		Use the form below if you wish to cancel the review.
	</p>
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="panel-title">
				Cancel Review
			</span>
		</div>
		<div class="panel-body">
			<form class="form" method="post" action="<?= $data->paperBaseUrl?>/cancel-review" >
				<button class="btn btn-default">Cancel Review <span class="glyphicon glyphicon-remove text-danger"></span></button></form>
			</div>
		</div>
	</div>
</div>