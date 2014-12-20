
		<h3>Upload</h3>
		<form method="post" enctype="multipart/form-data">
			<input type="file" name="file"/>
			<input type="submit" value="Upload"/>
		</form>
		<hr>
		<h4>Download</h4>
		<ul>
		<?php foreach($data->get('files', []) as $file) {
			?>
		<li><a href="test/<?= $file->getId()?>"><?= $file->getFilename() ?></a></li>
			<?php 
			
		}?>
		</ul>
