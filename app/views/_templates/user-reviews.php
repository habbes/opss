<?php
$reviews = $data->reviews;
?>
<div>
	<?php if(empty($reviews)){?>
	<p>No reviews found.</p>
	<?php } else { ?>
	<table class="table table-responsive">
		<thead>
			<tr>
				<th>Paper</th>
				<th>Review Status</th>
				<th>Started</th>
				<th>Completed</th>
				<th>Recommendation</th>
				<th>Admin Verdict</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($reviews as $review){
				$paper = $review->getPaper();
				$completed = $review->isCompleted();
				$link = $completed? $paper->getAbsoluteUrl()."/reviews/".$review->getId()."#review-".$review->getId() :
					$paper->getAbsoluteUrl();
			?>
			<tr data-id="<?= $review->getId() ?>">
				<td><a class="link" href="<?= $link ?>"><?= $paper->getTitle()?> (<?= $paper->getIdentifier() ?>)</a></td>
				<td><?= Review::getStatusString($review->getStatus())?></td>
				<td><?= Utils::siteDateFormat($review->getDateInitiated())?></td>
				<td><?= $completed? Utils::siteDateFormat($review->getDateSubmitted()) : "N/A" ?></td>
				<td><?= $completed? Review::getVerdictString($review->getRecommendation()) : "N/A" ?></td>
				<td><?= $completed? Review::getVerdictString($review->getAdminVerdict()) : "N/A" ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
</div>
