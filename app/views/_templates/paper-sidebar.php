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
<?php foreach($data->paperSidebarItems as $item) {?>
<div class="paper-sidebar-item">
	<?= $item ?>
</div>
<?php } ?>