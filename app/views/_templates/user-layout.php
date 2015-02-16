<div class="" id="user-layout">
	<ul class="nav nav-tabs" id="user-nav-list">
		<?php foreach($data->userNavLinks as $link) { 
			$active = $link->active? "active" : "";
			?>
			<li role="presentation" 
				class="user-nav-item <?= $active ?>"><a href="<?= $data->userBaseUrl . "/".$link->url ?>"><?=$link->name?></a></li>
		<?php } ?>
	</ul>
	<div class="" id="user-body">
		<div class="col-sm-12" id="user-page-content">
			<?= $data->userPageContent ?>
		</div>
		<span class="clearfix"></span>
	</div>
	

</div>