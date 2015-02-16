<?php 
$user = $data->selectedUser;
$reviews = $data->reviews;
?>
<div>
	<?php if(empty($reviews)){?>
	<p>No papers found.</p>
	<?php } else { ?>
	<table class="table table-responsive">
		<thead>
			<tr>
				<th>Paper</th>
				<th>Level</th>
				<th>Status</th>
				<th>Reviewing Since</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($reviews as $review){
			$paper = $review->getPaper();
			?>
			<tr data-id="<?= $paper->getId()?>">
				<td><a class="link" href="<?= $paper->getAbsoluteUrl() ?>"><?= $paper->getTitle() ?>
					(<?= $paper->getRevisionIdentifier()?>)</a></td>
				<td><?= PaperLevel::getString($paper->getLevel())?></td>
				<td><?= $paper->getStatusString() ?></td>
				<td><?= Utils::siteDateFormat($review->getDateInitiated())?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }  ?>

</div>