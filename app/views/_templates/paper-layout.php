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
		<div class="col-sm-10" id="paper-page-content">
			<?= $data->paperPageContent ?>
		</div>
		<div class="col-sm-2 col-sm-offset-10" id="paper-sidebar">
			<div class="paper-sidebar-item">
				<a class="btn btn-default" role="button" href="<?=$data->paperBaseUrl?>/download/main">Download Paper</a>
			</div>
			<?php foreach($data->paperSidebarItems as $item) {?>
			<div class="paper-sidebar-item">
				<?= $item ?>
			</div>
			<?php } ?>
		</div>
	</div>
	

</div>