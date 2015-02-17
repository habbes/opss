
<?php foreach($data->navLinks as $group) { ?>
<div class="nav nav-sidebar nav-list-header">
	<span class="glyphicon glyphicon-<?= $group['icon'] ?> nav-icon"></span>
	<span class="nav-list-header-text"><?= $group['name'] ?></span>
</div>
<ul class="nav nav-sidebar nav-list-group">
	<?php foreach($group['links'] as $link){
		$active = $link->active? "active" : "";
		$badge = "";
		if($group["name"] == "Papers" && $link->name == "All Papers"){
			if($data->badgeUnreadPapers > 0){
				$badge = ' <span class="badge" id="unread-papers-badge">'.$data->badgeUnreadPapers.'</span>';
			}
		}
		?>
	<li class="nav-item <?= $active ?>"><a href="<?= $link->url ?>"><?= $link->name ?><?= $badge ?></a></li>
	
	<?php } ?>
</ul>
<?php } ?>