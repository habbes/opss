<?php 

$formdata = $data->form or $formdata = new DataObject();
$formerror = $data->errors or $formerror = new DataObject();

?>
<div>
	<form method="post">
		<div class="form-group">
			<select name="month" class="form-control" required>
				<option value="">Select Month</option>
				<?php foreach($data->months as $month => $string){ 
					$selected = ($month == $formdata->month)? "selected" : "";
				?>
				<option value="<?= $month?>" <?= $selected?>><?= $string?></option>				
				<?php } ?>
			</select>
			<span class="form-error help-block"><?= $formerror->month?></span>
		</div>
		<div class="form-group">
			<select name="year" class="form-control" required>
				<option value="">Select Year</option>
				<?php foreach($data->years as $year){ 
					$selected = ($year == $formdata->year)? "selected" : "";
				?>
				<option value="<?= $year?>" <?= $selected?>><?= $year?></option>				
				<?php } ?>
			</select>
			<span class="form-error help-block"><?= $formerror->year?></span>
		</div>
		<div class="form-group">
			<button class="btn btn-success">Schedule Workshop</button>
		</div>
	</form>

</div>