
<div class="table-responsive">
	<table class="table table-striped table-hover records-table" id="presentation-pipeline">
		<?php if(count($data->papers) == 0 ) {?>
			No papers found.
		</table>
		<?php } else { ?>
		<thead>
			<tr>
				<th></th>
				<th style="width:30%">Title</th>
				<?php if($data->user->isAdmin()){?>
				<th>Researcher</th>
				<?php } ?>
				<th>Level</th>
				<th>Group</th>
				<th>Date Submitted</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($data->papers as $paper) {
				$unread = $paper->hasBeenViewedByAdmin()? "" : "unread info";
				?>
			<tr class="<?= $unread ?>">
				<td><input type="checkbox" class="record-selector" data-paper="<?= $paper->getId()?>"></td>
				<td><a class="link" href="<?=URL_PAPERS?>/<?=$paper->getIdentifier()?>"><?= escape($paper->getTitle())?> (<?= $paper->getIdentifier()?>)</a></td>
				<?php if($data->user->isAdmin()){ ?>
				<td><?= escape($paper->getResearcher()->getFullName())?></td>
				<?php } ?>
				<td><?= PaperLevel::getString($paper->getLevel())?></td>
				<td><?= PaperGroup::getString($paper->getThematicArea())?></td>
				<td><?= Utils::siteDateFormat($paper->getDateSubmitted()) ?></td>
			</tr>
			<?php } //end foreach ?>
		</tbody>
		<?php } //end if-else block?>
	</table>
	<p id="test" class="text-info"></p>
	<script>
	$(".record-selector").click(function(){
		var selectors = document.getElementById('presentation-pipeline').getElementsByClassName('record-selector');
		var count  = _.filter(selectors, function(s){return s.checked}).length;
		$("#test").text(count + (count === 1? ' paper' : ' papers') + ' selected.');
	});
	</script>
	

</div>
