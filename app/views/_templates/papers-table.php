
<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="papers-table">
		<?php if(count($data->papers) == 0 ) {?>
			No papers found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th style="width:30%">Title</th>
				<?php if($data->user->isAdmin()){?>
				<th>Researcher</th>
				<?php } ?>
				<th>Level</th>
				<th>Status</th>
				<th>Date Submitted</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->papers as $paper) {
				$unread = $paper->hasBeenViewedByAdmin()? "" : "unread info";
				?>
			<tr class="<?= $unread ?>">
				<td><a class="link" href="<?=URL_PAPERS?>/<?=$paper->getIdentifier()?>"><?= escape($paper->getTitle())?> (<?= $paper->getIdentifier()?>)</a></td>
				<?php if($data->user->isAdmin()){ ?>
				<td><?= escape($paper->getResearcher()->getFullName())?></td>
				<?php } ?>
				<td><?= PaperLevel::getString($paper->getLevel())?></td>
				<td><?= $paper->getStatusString()?></td>
				<td><?= Utils::siteDateFormat($paper->getDateSubmitted()) ?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>

</div>
