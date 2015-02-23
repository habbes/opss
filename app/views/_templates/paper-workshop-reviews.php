<div>
	<?php if(count($data->reviews) == 0) { ?>
	<p>No reviews found.</p>
	<?php } else {?>
	<div class="panel-group" id="review-list" role="tablist" aria-multiselectable="true">
		<?php foreach($data->reviews as $review) { 
			$reviewId = "review-".$review->getId();
			$selected = $data->selectedReview? $review->getId() == $data->selectedReview->getId() : false;
		?>
		<div class="panel panel-default" id="<?=$reviewId?>">
			<div class="panel-heading" role="tab" id="<?=$reviewId?>-heading">
				<h4 class="panel-title">
					<a class="<?= $selected? "":"collapsed"?>" data-toggle="collapse" data-parent="#review-list" 
					href="<?="#". $reviewId?>-body"
						aria-expanded="true" aria-controls="<?= $reviewId?>-body">
					<?= $review->getWorkshop()->toString() ?>
					</a>
				</h4>
			</div>
			<div id="<?= $reviewId?>-body" class="panel-collapse collapse <?= $selected? "in" : ""?>" 
				role="tabpanel" aria-labelledby="<?=$reviewId?>-heading">
				<div class="panel-body">
					<?php if($data->role->isAdmin()) {?>
					<div>Reviewed by <a class="link" 
						href="<?=$review->getAdmin()->getAbsoluteUrl()?>"><?= $review->getAdmin()->getFullName()?></a></div>
					<?php } ?>
					<div>Submitted on <?= Utils::siteDateFormat($review->getDateSubmitted()) ?></div>
					<div>
						<h5>Conclusion</h5>
						<div>
						<?= WorkshopReview::getVerdictString($review->getVerdict())?>
						</div>
					</div>
					
					<div>
						<h5 class="font-bold">Comments</h5>
						<?php if($review->hasFile()){?>
						<div><i>
							More comments were provided in
							<a class="link" href="<?= $data->paperBaseUrl?>/workshop-reviews/<?= $review->getId()?>/file">this file</a>.
							</i>
						</div>
						<?php } ?>
						<p><?= $review->getComments()?></p>
					</div>
					
					
				</div>
			</div>
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>