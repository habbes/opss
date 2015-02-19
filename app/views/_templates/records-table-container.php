<div class="records-group-container">
	<div class="records-search-container col-sm-4 pull-right input-group">
		<input type="text" class="form-control search-field" id="<?= $data->searchFieldId?>" placeholder="Enter query to start search" >
		<span class="input-group-addon " id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
	</div>
	<span class="clearfix"></span>
	<div class="records-table-container">
		<?= $data->recordsTable ?>
	</div>
</div>
