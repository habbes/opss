<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="workshop-papers-table">
		<?php if(count($data->workshop->getPapers()) == 0 ) {?>
			No reviewers found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th>Paper</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->workshop->getPapers() as $paper) { ?>
			<tr>
				<td><a class="link" href="<?= $paper->getAbsoluteUrl()?>"><?= $paper->getTitle()?> (<?= $paper->getRevisionIdentifier()?>)</a></td>
				<td><?= $paper->getStatusString()?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>
</div>