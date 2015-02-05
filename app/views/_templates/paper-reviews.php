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
					<?= Utils::siteDateFormat($review->getDateSubmitted()) ?>
					</a>
				</h4>
			</div>
			<div id="<?= $reviewId?>-body" class="panel-collapse collapse <?= $selected? "in" : ""?>" 
				role="tabpanel" aria-labelledby="<?=$reviewId?>-heading">
				<div class="panel-body">
					<?php if($data->role->isAdmin()) {?>
					<div>Reviewed by <?= $review->getReviewer()->getFullName()?></div>
					<?php } ?>
					<?php if($data->role->canViewReviewCommentsToAdmin($review)){?>
					<div>
						<h5 class="font-bold">Comments to Secretariate</h5>
						<?php if($review->hasFileToAdmin()){?>
						<div><i>
							More comments were provided in
							<a class="link" href="<?= $data->paperBaseUrl?>/reviews/<?= $review->getId()?>/file-admin">this file</a>.
							</i>
						</div>
						<?php } ?>
						<p><?= $review->getCommentsToAdmin()?></p>
					</div>
					<?php } ?>
					<?php if($data->role->canViewReviewCommentsToAuthor($review)){?>
					<div>
						<h5 class="font-bold">Comments to Author</h5>
						<?php if($review->hasFileToAuthor()){?>
						<div><i>
							More comments were provided in
							<a class="link" href="<?= $data->paperBaseUrl?>/reviews/<?= $review->getId()?>/file-author">this file</a>.
							</i>
						</div>
						<?php } ?>
						<p><?= $review->getCommentsToAuthor()?></p>
					</div>
					<?php } ?>
					<?php if($data->role->canViewReviewAdminComments($review)){?>
					<div>
						<h5 class="font-bold">Comments from Secretariate</h5>
						<?php if($review->hasAdminFile()){?>
						<div><i>
							More comments were provided in
							<a class="link" href="<?= $data->paperBaseUrl?>/reviews/<?= $review->getId()?>/admin-file">this file</a>.
							</i>
						</div>
						<?php } ?>
						<p><?= $review->getAdminComments()?></p>
					</div>
					<?php } ?>
					
				</div>
			</div>
			
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>