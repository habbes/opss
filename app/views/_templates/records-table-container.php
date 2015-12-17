<div class="records-group-container">
	<div class="records-search-container col-sm-4 col-sm-offset-8 input-group">
		<input type="text" data-endpoint="<?= $data->searchEndpoint ?>" data-url="<?= $data->searchUrl?>" 
		class="form-control search-field" id="<?= $data->searchEndpoint?>-search-field" placeholder="Type to search" >
		<span class="input-group-addon " id="search-button"><span class="glyphicon glyphicon-search"></span></span>
	</div>
	<?php if($data->filters) {?>
	<div class="records-search-filters-container col-md-12">
	
		<?php foreach($data->filters as $filter){ ?>
		<div class="record-search-filter col-md-2">
		<?php 
		if($filter['type'] == 'select'){	
		?>
		<label><?= $filter['label']?></label>
		<select name="<?= $filter['name']?>" class="form-control">
			<option value="">All</option>
			<?php foreach($filter['options'] as $index => $option){ ?>
			<option value="<?= $option ?>"><?= $filter['optionLabels'][$index] ?></option>
			<?php } ?>
		</select>
		
		<?php } else {?>
		<?php } ?>
		</div>
		<?php } ?>
		<div class="clearfix"></div><br>
	</div>
	<?php } ?>
	<div class="records-table-container col-md-12" id="<?= $data->searchEndpoint ?>-table-container" >
		<?= $data->recordsTable ?>
	</div>
	<div class="clearfix"></div>
</div>
