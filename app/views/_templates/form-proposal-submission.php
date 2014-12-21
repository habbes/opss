<div class="form">
			 	<form class="form-horizontal" action='' method="POST" enctype="multipart/form-data" role="form">
  					<fieldset>
      					<legend class="">Submit proposal</legend>
    				<div class="form-group">
      					<!-- Title -->
      					<label class="control-label col-sm-1 col-lg-2"  for="title">Title</label>
      					<div class="col-sm-3 col-md-5">
      						<input type="text" id="title" name="title" placeholder="" class="form-control">
      						<span class="help-block alert-danger" id="titleErrorMessage"></span>
        					<p class="help-block">Please provide the title of the proposal</p>
      					</div>
    				</div>
				    <div class="form-group">
				      <!-- main document -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Main document</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="file" id="file" name="file" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="fileErrorMessage"></span>
				        <p class="help-block">Please provide your first name</p>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- Document cover -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Second name</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="file" id="cover" name="cover" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="secondNameErrorMessage"></span>
				        <p class="help-block">Please provide the cover of your document</p>
				      </div>
				    </div>
 					 <div class="form-group">
				      <!-- First co-author -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Name or Email of 1<sup>st</sup> co-author</label>
				      <div class="col-sm-3 col-md-5">
				  		 <input type="text" id="author1" name="author1" placeholder="" class="form-control">
				      	<span class="help-block alert-danger" id="author1ErrorMessage"></span>
				        <p class="help-block">Please provide the name or email of your first co-author</p>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- Second co-author -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Name or Email of 2<sup>nd</sup> co-author</label>
				      <div class="col-sm-3 col-md-5">
				  		 <input type="text" id="author1" name="author2" placeholder="" class="form-control">
				      	<span class="help-block alert-danger" id="author2ErrorMessage"></span>
				        <p class="help-block">Please provide the name or email of your second co-author</p>
				      </div>
				    </div>
    				<div class="form-group">
      					<!-- Country of Residence -->
      					<label class="control-label col-sm-1 col-lg-2"  for="username">Country of residence</label>
      					<div class="col-sm-3 col-md-5">
      						<select class="form-control" title="select your country of residence" name="residence">
      							<option>--Select One--</option>
      							<?php foreach(file("app/sys_data/countries-en",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $country){ ?>
      								<option><?=$country?></option>
      							<?php } ?>
      						</select>
      						<span class="help-block alert-danger" id="residenceErrorMessage"></span>
        					<p class="help-block">Please select your country of residence</p>
      					</div>
    				</div>
    				<div class="form-group">
				      <!-- Paper language -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Language of the paper</label>
				      <div class="col-sm-3 col-md-5">
				       <select class="form-control" title="select your country of residence" name="residence">
      							<option>--Select One--</option>
      							<option>English</option>
      							<option>French</option>
      							<option>Portuguese</option>
      						</select>
				        <span class="help-block alert-danger" id="languageErrorMessage"></span>
				        <p class="help-block">Please provide the language of the paper</p>
				      </div>
				    </div>
				    </fieldset>
				    <fieldset>
				    	<legend>Completion</legend>
    					<div class="form-group">
      					<!-- Button -->
      						<div class="col-sm-offset-1">
        						<button type="submit" class="btn btn-success inline">Submit proposal</button>
        						<button style="margin-left: 280px" type="reset" class="btn btn-fail">Clear</button>
     						</div>
    					</div>
    				</fieldset>
</form>