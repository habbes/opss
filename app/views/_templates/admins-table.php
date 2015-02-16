<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="admins-table">
		<?php if(count($data->admins) == 0 ) {?>
			No admins found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th style="width:50%">Name</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->admins as $admin) { ?>
			<tr data-id="<?= $admin->getId() ?>">
				<td><a class="link" href="<?=$admin->getAbsoluteUrl()?>"><?= escape($admin->getFullName())?></a></td>
				<td><?= escape($admin->getEmail())?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>
</div>
