<div class="paper-sidebar-item panel panel-default">
	<div class="panel-heading">
		<span class="">Downloads</span>
	</div>
	<div class="panel-body">
		<div>
			<span class="glyphicon glyphicon-download"></span>
			<a class="link" role="button" href="<?=$data->paperBaseUrl?>/download">Download Paper</a>
		</div>
		<?php if($data->user->getRole()->canViewPaperCover()) { ?>
		<div>
			<span class="glyphicon glyphicon-download"></span>
			<a class="link" role="button" href="<?=$data->paperBaseUrl?>/download/cover">Download Cover</a><br>
		</div>
		<?php } ?>
	</div>			
</div>

<?php if($data->user->getRole()->canViewPaperAuthor()) { ?>
<div class="paper-sidebar-item panel panel-default">
	<div class="panel-heading">
		<span class="">Authors</span>
	</div>
	<div class="panel-body">
		<div>
			<span class="font-bold">Principal Researcher</span><br>
			<?php if($data->user->isAdmin()){?>
			<span><a href="<?=$data->paper->getResearcher()->getAbsoluteUrl()?>" 
				class="link"><?= $data->paper->getResearcher()->getFullName() ?></a></span>
			<?php } else { ?>
			<span><?= $data->paper->getResearcher()->getFullName() ?></span>
			<?php } ?>
		</div>
		<?php if($data->paper->getAuthors()) {?>
		<div>
			<span class="font-bold">Co-Authors</span><br>
			<?php foreach($data->paper->getAuthors() as $author) { ?>
			<span><?= sprintf("%s (%s)", $author->getName(), $author->getEmail())?></span><br>
			<?php } ?>
		</div>
		<?php } ?>
	</div>			
</div>
<?php } ?>

<div class="paper-sidebar-item panel panel-default">
	<div class="panel-heading">
		<span class="">Details</span>
	</div>
	<div class="panel-body">
		<div>
			<span class="font-bold">Language</span><br>
			<span><?= $data->paper->getLanguage() ?></span>
		</div>
		<div>
			<span class="font-bold">Country of Research</span><br>
			<span><?= $data->paper->getCountry() ?></span>
		</div>
		<div>
			<span class="font-bold">Level</span><br>
			<span><?= PaperLevel::getString($data->paper->getLevel())?></span>
		</div>
		<?php if($data->paper->getThematicArea()){?>
		<div>
			<span class="font-bold">Thematic Area</span><br>
			<span><?= PaperGroup::getString($data->paper->getThematicArea())?></span>
		</div>
		<?php } ?>
		<div>
			<span class="font-bold">Status</span><br>
			<span><?= $data->paper->getStatusString() ?></span>
		</div>
		<div>
			<span class="font-bold">Date Submitted</span><br>
			<span><?= Utils::siteDateTimeFormat($data->paper->getDateSubmitted())?></span>
		</div>
		
	</div>			
</div>

<?php foreach($data->paperSidebarItems as $item) {?>
<div class="paper-sidebar-item">
	<?= $item ?>
</div>
<?php } ?>