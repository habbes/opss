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
		<?php 
		$alertType = "";
		$alertStyle = "";
		if($this->data->resultMessage){
			$alertStyle = 'style="display:block"';
			switch($this->data->resultMessageType){
				case "error":
					$alertType = "alert-danger";
					break;
				case "success":
					$alertType = "alert-success";
					break;
				default:
					$alertType = "alert-info";
			}
		}
		?>
		<div id="result-message-container" role="alert" class="alert alert-dismissble <?=$alertType?>" <?= $alertStyle?> >
			<button type="button" class="close" data-dismiss="alert" 
				aria-label="Close"><span aria-hidden="true" >&times;</span></button>
			<span id="result-message"><?= $this->data->resultMessage ?></span>
		</div>
		<h2 class="page-header"><?= $data->pageHeading ?></h2>
		<div  id="page-content">
			<?= $data->pageContent ?>
		</div>
		
		<footer id="footer" >
			<p id="footer-contact">Contact us on <a href="mailto:research@aercafrica.org">research@aercafrica.org</a></p>
		</footer>	
		
	</div>
</div>
