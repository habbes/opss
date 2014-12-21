		<div class="form">
		<fieldset>
			<legend>Upload</legend>
				<form method="post" enctype="multipart/form-data" role="form" class="form">
					<div class="form-group">
						<label class="control-label col-sm-1 col-lg-4"  for="title">Select file</label>
						<div class="col-sm-3 col-md-5">
							<input type="file" name="file" class="form-control"/>
							<p class="help-block">Please choose file to upload</p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-1 col-lg-4" for="">Finish him!!</label>
						<div class="col-sm-3 col-md-5">
							<button type="submit" value="Upload" class="btn btn-success form-control">Upload</button>
						</div>
					</div>
				</form>
		</fieldset>
		</div>
		<hr>
		<h4>Download</h4>
		<ul class="list-group">
		<?php foreach($data->get('files', []) as $file) {
			?>
		<li   class="list-group-item"><span class="glyphicon glyphicon-file"></span><a href="test/<?= $file->getId()?>"><?= $file->getFilename() ?></a></li>
			<?php 
			
		}?>
		</ul>
