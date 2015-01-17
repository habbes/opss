<div class="row" id="paper-layout">
	<ul class="nav nav-tabs" id="paper-nav-list">
		<?php foreach($data->paperNavLinks as $link) { 
			$active = $link->active? "active" : "";
			?>
			<li role="presentation" 
				class="paper-nav-item <?= $active ?>"><a href="<?= urlencode($data->paperBaseUrl . $link->url) ?>"><?=$link->name?></a>
		<?php } ?>
	</ul>
	<div class="row" id="paper-body">
		<div class="row" id="paper-content">
			<?= $data->paperContent ?>
		</div>
		<div class="row" id="paper-sidebar">
			<?= $data->paperSidebar ?>
		</div>
	</div>
	

</div>