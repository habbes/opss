<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="reviewers-table">
		<?php if(count($data->workshop->getPapers()) == 0 ) {?>
			No reviewers found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th>Date</th>
				<th>Papers in pipeline</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->workshops as $workshop) { ?>
			<tr data-id="<?= $workshop->getId() ?>">
				<td><a class="link" href="<?= $workshop->getAbsoluteUrl()?>"><?= $workshop->toString()?></a></td>
				<td>0</td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>
</div>