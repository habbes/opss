<div>
	<?php foreach($this->data->paperChanges as $change){ ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= $change->getAction(); ?>
		</div>
		<div class="panel-body">
		<?php switch($change->getAction()) { 
			case PaperChange::ACTION_SUBMITTED : ?>
			Submitted details
			<?php break;
			case PaperChange::ACTION_TITLE_CHANGED : ?>
			title changed details
			<?php break;?>
		<?php } ?>
		</div>
	</div>
	<?php } ?>
</div>