<div class="col-sm-3 col-md-2 sidebar">
		<?=isset($data->nav)?$data->nav:"No navigation template to show.. Maybe you should use \$data->nav instead"?>
</div>
<div class="col-sm-3 col-sm-offset-4 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?=isset($data->pageHeading)?$data->pageHeading:"No Heading"?></h1>
          <?=isset($data->pageContent)?$data->pageContent:"No data to display"?>
          
</div>