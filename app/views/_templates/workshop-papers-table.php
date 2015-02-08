<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="workshop-papers-table">
		<?php if(count($data->workshop->getPapers()) == 0 ) {?>
			No papers found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th>Paper</th>
				<th>Level</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->workshop->getPapers() as $paper) { ?>
			<tr>
				<td><a class="link" href="<?= $paper->getAbsoluteUrl()?>"><?= $paper->getTitle()?> (<?= $paper->getRevisionIdentifier()?>)</a></td>
				<td><?= PaperLevel::getString($paper->getLevel())?>
				<td><?= $paper->getStatusString()?></td>
				<td><form class=".form-inline" method="post" action="<?= $paper->getAbsoluteUrl()?>/remove-from-workshop"><button class="btn btn-default"><span class="glyphicon glyphicon-remove text-danger"></span> Remove</button></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>
</div>