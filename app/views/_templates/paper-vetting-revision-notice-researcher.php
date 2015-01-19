<div>
	<p>
	The paper has been returned from vetting for further revision.
	Open the <a href="<?= $data->paperBaseUrl?>/edit">Edit page</a> to make the necessary modifications.
	When you are ready, resubmit the revised paper.
	</p>
	
	<h5 class="font-bold">Comments from the secretariate</h5>
	<p>
	<?= $data->vetReview->getComments()?>
	</p>
	<div>
		
		<form class="form-inline" method="post" action="<?$data->paperBaseUrl?>/resubmit">
			<span class="font-bold">Ready to resubmit?</span>
			<button class="btn btn-primary" >Submit revised paper</button>
		</form>
	</div>
</div>