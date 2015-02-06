<div>
	<p>
	The paper has been returned for revision after a review. The conclusion of the review was:<br>
	<span class="font-bold"><?= Review::getVerdictString($data->review->getAdminVerdict())?></span>.<br>
	Click <a class="link" href="<?= $data->paperBaseUrl?>/reviews/<?= $data->review->getId()?>">here</a> for
	more details about the review.<br>
	
	Open the <a href="<?= $data->paperBaseUrl?>/edit">Edit page</a> to make the necessary modifications.
	</p>
	
	<div>
		
		<form method="post" action="<?= $data->paperBaseUrl?>/resubmit">
			<span class="font-bold">Ready to resubmit?</span>
			<button class="btn btn-success" >Submit revised paper</button>
		</form>
	</div>
</div>