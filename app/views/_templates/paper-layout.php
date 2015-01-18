<div class="" id="paper-layout">
	<ul class="nav nav-tabs" id="paper-nav-list">
		<?php foreach($data->paperNavLinks as $link) { 
			$active = $link->active? "active" : "";
			?>
			<li role="presentation" 
				class="paper-nav-item <?= $active ?>"><a href="<?= $data->paperBaseUrl . "/".$link->url ?>"><?=$link->name?></a></li>
		<?php } ?>
	</ul>
	<div class="" id="paper-body">
		<div class="col-sm-9" id="paper-page-content">
			<?= $data->paperPageContent ?>
		</div>
		<div class="col-sm-3 col-sm-offset-9" id="paper-sidebar">
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
		</div>
	</div>
	

</div>