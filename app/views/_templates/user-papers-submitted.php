<?php 
$user = $data->selectedUser;
$papers = $data->papers;
?>
<div>
	<?php if(empty($papers)){?>
	<p>No papers found.</p>
	<?php } else { ?>
	<table class="table table-responsive">
		<thead>
			<tr>
				<th>Paper</th>
				<th>Level</th>
				<th>Status</th>
				<th>Date Submitted</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($papers as $paper){?>
			<tr data-id="<?= $paper->getId()?>">
				<td><a class="link" href="<?= $paper->getAbsoluteUrl() ?>"><?= $paper->getTitle() ?>
					(<?= $paper->getRevisionIdentifier()?>)</a></td>
				<td><?= PaperLevel::getString($paper->getLevel())?></td>
				<td><?= $paper->getStatusString() ?></td>
				<td><?= Utils::siteDateFormat($paper->getDateSubmitted())?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }  ?>

</div>