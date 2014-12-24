<div class="col-sm-3 col-sm-offset-4 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?=$data->pageHeading?></h1>
	<div class="form">
		<fieldset>
			<legend>Upload</legend>
				<form method="post" enctype="multipart/form-data" role="form" class="form">
					<div class="form-group">
						<label class="control-label col-sm-1 col-lg-4"  for="title">Select file</label>
						<div class="col-sm-3 col-md-5">
							<input type="file" name="file" class=" input-md"/>
							<p class="help-block">Please choose file to upload</p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-1 col-lg-4" for="">Finish him!!</label>
						<div class="col-sm-3 col-md-5">
							<button type="submit" value="Upload" class="btn btn-success">Upload</button>
						</div>
					</div>
				</form>
		</fieldset>
		</div>
		<hr>
		<h4>Download</h4>
		<div class="list-group">
		<?php 
		$i = 0;
		foreach($data->get('files', []) as $file) {
			?>
		<a   class="list-group-item" href="test/<?= $file->getId()?>"><p class="list-group-item-text"><span class="glyphicon glyphicon-file"></span> <?= $file->getFilename() ?></p></a>
			<?php 
			$i++;
		}?>
		</div>
</div>