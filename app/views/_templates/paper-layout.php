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
		<div class="col-sm-9 " id="paper-page-content">
			<?= $data->paperPageContent ?>
		</div>
		<div class="col-sm-3 pull-right " id="paper-sidebar">
			<?= $data->paperSidebar ?>
		</div>
	</div>
	

</div>