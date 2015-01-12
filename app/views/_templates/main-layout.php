<div class="row">
	<?php 
	$rightCols="12";
	$rightOffset = "";
	if($data->pageNav){
		$rightCols="10";
		$rightOffset="col-md-offset-2 col-sm-offset-3"
	?>
	<div class="col-md-2 col-sm-3 sidebar" id="left-col">
		<div id="page-nav">
			<?= $data->pageNav ?>
		</div>
	</div>
		
	<?php }?>
	<div class="col-md-<?= $rightCols ?> <?= $rightOffset ?> main" id="right-col">
		<h2 class="page-header"><?= $data->pageHeading ?></h2>
		<div  id="page-content">
			<?= $data->pageContent ?>
		</div>
		
		<footer id="footer" >
			<p id="footer-contact">Contact us on <a href="mailto:research@aercafrica.org">research@aercafrica.org</a></p>
		</footer>	
		
	</div>
</div>
