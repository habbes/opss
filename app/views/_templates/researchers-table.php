<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="researchers-table">
		<?php if(count($data->researchers) == 0 ) {?>
			No researchers found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th style="">Name</th>
				<th>Email</th>
				<th>Country of Nationality</th>
				<th>Country of residence</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->researchers as $researcher) { ?>
			<tr data-id="<?= $researcher->getId() ?>">
				<td><?= escape($researcher->getFullName()) ?></td>
				<td><?= escape($researcher->getEmail())?></td>
				<td><?= escape($researcher->getNationality())?></td>
				<td><?= escape($researcher->getResidence())?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>
</div>
