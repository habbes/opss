
<?php foreach($data->navLinks as $group) { ?>
<div class="nav nav-sidebar nav-list-header">
	<span class="glyphicon glyphicon-<?= $group['icon'] ?> nav-icon"></span>
	<span class="nav-list-header-text"><?= $group['name'] ?></span>
</div>
<ul class="nav nav-sidebar nav-list-group">
	<?php foreach($group['links'] as $link){
		$active = $link->active? "active" : "";
		$badge = "";
		if($link->badgeName){
			$badgeData = $this->data->get("badge".$link->badgeName);
			$badgeId = $link->badgeId? 'id="'."{$link->badgeId}-nav-badge".'"' : "";
			if($badgeData > 0){
				$badge =  sprintf(' <span class="badge" %s>%s</span>', $badgeId, $badgeData);
			}
		}
		?>
	<li class="nav-item <?= $active ?>"><a href="<?= $link->url ?>"><?= $link->name ?><?= $badge ?></a></li>
	
	<?php } ?>
</ul>
<?php } ?>