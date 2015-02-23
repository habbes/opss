<div class="records-group-container">
	<div class="records-search-container col-sm-4 col-sm-offset-8 input-group">
		<input type="text" class="form-control search-field" id="<?= $data->searchFieldId?>" placeholder="Type to search" >
		<span class="input-group-addon " id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
	</div>
	<div class="records-table-container" id="<?= $data->tableContainerId ?>" >
		<?= $data->recordsTable ?>
	</div>
</div>
