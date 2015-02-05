<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="reviewers-table">
		<?php if(count($data->reviewers) == 0 ) {?>
			No reviewers found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th style="width:80%">Name</th>
				<th>Email</th>
				<th>Gender</th>
				<th>Currently Reviewing</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->reviewers as $reviewer) { ?>
			<tr data-id="<?= $reviewer->getId() ?>">
				<td><?= escape($reviewer->getFullName()) ?></td>
				<td><?= escape($reviewer->getEmail())?></td>
				<td><?= count($reviewer->getCurrentReviews())?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>
</div>
