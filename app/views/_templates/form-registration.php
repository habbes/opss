<?php 
$formdata = $data->form;
$formerror = $data->errors;
?>
<div class="col-sm-3 col-sm-offset-4 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?=$data->pageHeading?></h1>
<div class="form">
			 	<form class="form-horizontal" method="POST" role="form">
  					<fieldset>
      					<legend class="">Personal info</legend>
    				<div class="form-group">
      					<!-- Title -->
      					<label class="control-label col-sm-1 col-lg-2"  for="title">Title</label>
      					<div class="col-sm-3 col-md-5">
      						<select class="form-control" name="title">
      							<option value="">Select Title</option>
      						<?php foreach($data->titles as $title){	?>
      							<option value="<?=$title?>"
      							<?php if($title == $formdata->title) echo "selected"; ?>
      							><?= $title ?></option>	
      						<?php }	?>
      						</select>
      						<span class="help-block alert-danger" class="form-error" id="title-error"><?= $formerror->title ?></span>
      					</div>
    				</div>
    				
				    <div class="form-group">
				      <!-- First name -->
				      <label class="control-label col-sm-1 col-lg-2" for="firstname">First name</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="firstname" name="firstname" value="<?=$formdata->firstname?>"
				        	placeholder="" class="form-control">
				        <span class="help-block alert-danger" class="form-error" id="firstname-error"><?= $formerror->firstname ?></span>
				      </div>
				    </div>
				    
				    <div class="form-group">
				      <!-- Second name -->
				      <label class="control-label col-sm-1 col-lg-2" for="lastname">Last name</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="lastname" name="lastname" value="<?=$formdata->lastname?>" 
				        	placeholder="" class="form-control">
				        <span class="help-block alert-danger" class="form-error" id="lastname-error"><?= $formerror->lastname ?></span>
				      </div>
				    </div>
				    
 					 <div class="form-group">
				      <!-- Gender -->
				      <label class="control-label col-sm-1 col-lg-2" for="gender">Gender</label>
				      <div class="col-sm-3 col-md-5">
				      	<label class="radio-inline"><input type="radio" value="male" name="gender"
				      	<?php if($formdata->gender == "male") echo "checked"; ?> >Male</label>
				      	
				      	<label class="radio-inline"><input type="radio" value="female" name="gender"
				      	<?php if($formdata->gender == "female") echo "checked"; ?> >Female</label>
				      	<span class="help-block alert-danger" class="form-error" id="gender-error"><?= $formerror->gender ?></span>
				      </div>
				    </div>
				    
				    <div class="form-group">
      					<!-- Nationality -->
      					<label class="control-label col-sm-1 col-lg-2"  for="nationality">Country of Nationality</label>
      					<div class="col-sm-3 col-md-5">
      						<select class="form-control" id="nationality" title="select your country of nationality" name="nationality">
      							<option value="">Select Country</option>
      							<?php foreach($data->countries as $country){ ?>
      								<option value="<?=$country?>"
      								<?php if($country == $formdata->nationality) echo "selected"; ?> ><?=$country?></option>
      							<?php } ?>
      						</select>
      						<span class="help-block alert-danger" class="form-error" 
      						id="nationality-error"><?= $formerror->nationality ?></span>
      					</div>
    				</div>
    				
    				<div class="form-group">
      					<!-- Residence -->
      					<label class="control-label col-sm-1 col-lg-2"  for="residence">Country of Residence</label>
      					<div class="col-sm-3 col-md-5">
      						<select class="form-control" title="select your country of residence" name="residence">
      							<option value="">Select Country</option>
      							<?php foreach($data->countries as $country){ ?>
      								<option value="<?=$country?>"
      								<?php if($country == $formdata->residence) echo "selected"; ?> ><?=$country?></option>
      							<?php } ?>
      						</select>
      						<span class="help-block alert-danger form-error" id="residence-error"><?= $formerror->residence ?></span>
      					</div>
    				</div>
    				
    				
				    
				    <div class="form-group">
				      <!-- Address -->
				      <label class="control-label col-sm-1 col-lg-2" for="address">Address</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="address" name="address" value="<?= $formdata->address ?>"
				        placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" id="address-error"><?= $formerror->address ?></span>
				      </div>
				    </div>
				    
				    </fieldset>
				    <fieldset>
				    	<legend>Area of specialization</legend>
				    	<div class="form-group">
	      					<!-- Thematic research -->
	      					<label class="control-label col-sm-1 col-lg-2"  for="thematic-area">Thematic research</label>
	      					<div class="col-sm-3 col-md-5">
	      						<select class="form-control" title="select your thematic research area" name="thematic-area">
	      						<?php foreach($data->researchAreaValues as $area ){?>
	      							<option value="<?=$area?>"
	      							<?php if($area == $formdata->get("thematic-area")) echo "selected"; ?>
	      							><?= $data->researchAreaNames[$area]?></option>
	      						<?php } ?>
	      						</select>
	      						<span class="help-block alert-danger form-error" 
	      						id="thematic-area-error"><?= $formerror->get("thematic-area") ?></span>
	      					</div>
    					</div>
    					<div class="form-group">
	      					<!-- collaborative research -->
	      					<label class="control-label col-sm-1 col-lg-2"  for="collaborative-area">Collaborative research</label>
	      					<div class="col-sm-3 col-md-5">
	      						<select class="form-control" title="select your collaborative research area" name="collaborative-area">
	      						<?php foreach($data->researchAreaValues as $area ){?>
	      							<option value="<?=$area?>"
	      							<?php if($area == $formdata->get("collaborative-area")) echo "selected"; ?>
	      							><?= $data->researchAreaNames[$area]?></option>
	      						<?php } ?>
	      						</select>
	      						<span class="help-block alert-danger" 
	      						id="collaborative-area-error"><?= $formerror->get("collaborative-area") ?></span>
	      					</div>
    					</div>
				    </fieldset>
				    <fieldset>
				    	<legend>Account access info</legend>
				    	<div class="form-group">
				      <!-- username -->
				      <label class="control-label col-sm-1 col-lg-2" for="username">Username</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="username" name="username" value="<?= $formdata->username; ?>"
				        placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" id="username-error"><?= $formerror->username ?></span>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- E-mail -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Email</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="email" id="email" name="email" value="<?= $formdata->email ?>"
				        placeholder="" class="form-control" >
				        <span class="help-block alert-danger form-error" id="email-error"><?= $formerror->email ?></span>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- password -->
				      <label class="control-label col-sm-1 col-lg-2" for="password">Password</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="password" id="password" name="password" placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" id="password-error"><?= $formerror->password ?></span>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- password confirm  -->
				      <label class="control-label col-sm-1 col-lg-2" for="password-confirm">Confirm Password</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="password" id="password-confirm" name="password-confirm" placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" 
				        id="password-confirm-error"><?= $formerror->get("password-confirm") ?></span>
				      </div>
				    </div>
				    </fieldset>
				    <fieldset>
				    	<legend>Completion</legend>
    					<div class="form-group">
      					<!-- Button -->
      						<div class="col-sm-offset-1">
        						<input type="submit" class="btn btn-success inline" value="Proceed"/>
        						<input style="margin-left: 280px" type="reset" class="btn btn-fail" value="Clear"/>
     						</div>
    					</div>
    				</fieldset>
</form>
<script>
	
	var pass = $("#password");
	var passConfirm = $("#password-confirm");
	passConfirm.on("keyup", function(){
		$(this).addClass("alert");
		if(pass.val() != $(this).val()){
			$(this).addClass("alert-warning").removeClass("alert-success");
		}
		else {
			$(this).addClass("alert-success").removeClass("alert-warning");
		}
	});
</script>
</div>
</div>