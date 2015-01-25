
<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="papers-table">
		<?php if(count($data->papers) == 0 ) {?>
			No papers found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th style="width:40%">Title</th>
				<th>Researcher</th>
				<th>Level</th>
				<th>Status</th>
				<th>Date Submitted</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->papers as $paper) { ?>
			<tr>
				<td><a class="link" href="<?=URL_PAPERS?>/<?=$paper->getIdentifier()?>"><?= escape($paper->getTitle()) ?></a></td>
				<td><?= escape($paper->getResearcher()->getFullName())?></td>
				<td><?= PaperLevel::getString($paper->getLevel())?></td>
				<td><?= $paper->getStatus()?></td>
				<td><?= Utils::siteDateFormat($paper->getDateSubmitted()) ?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>

</div>
