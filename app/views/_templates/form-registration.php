<?php 
$formdata = $data->form;
$formerror = $data->errors;
?>
<style>
	.err{
		color: red;
	}
</style>
<div class="form">
			 	<form class="form-horizontal" method="POST" role="form">
			 		<input type="hidden" name="action" value="registration"/>
  					<fieldset>
    				<div class="form-group">
      					<!-- Title -->
    				<div class="form-group">
      					<!-- Title -->
      					<label class="control-label col-sm-1 col-lg-2"  for="title">Names</label>
      					<div class="col-sm-3 col-md-1" style="padding-right:0px">
      						<select class="form-control" name="title" style="border-radius: 4px 0px 0px 4px;border-right: none">
      							<option value="">Title</option>
      						<?php foreach($data->titles as $title){	?>
      							<option value="<?=$title?>"
      							<?php if($title == $formdata->title) echo "selected"; ?>
      							><?= $title ?></option>	
      						<?php }	?>
      						</select>
      						<span class="help-block err" class="form-error" id="title-error"><?= $formerror->title ?></span>
      					</div>
				      <!-- First name -->
				      <div class="col-sm-3 col-md-2" style="padding-left: 0px;padding-right:0px">
				        <input type="text" id="firstname" style="border-radius: 0px;border-right: none;border-left: none" name="firstname" value="<?=$formdata->firstname?>"
				        	placeholder="First name" class="form-control">
				        <span class="help-block err" class="form-error" id="firstname-error"><?= $formerror->firstname ?></span>
				      </div>
				      <!-- Second name -->
				      <div class="col-sm-3 col-md-2" style="padding-left: 0px">
				        <input type="text" id="lastname" name="lastname" style="border-radius: 0px 4px 4px 0px;border-left: none" value="<?=$formdata->lastname?>" 
				        	placeholder="Last name" class="form-control">
				        <span class="help-block err" class="form-error" id="lastname-error"><?= $formerror->lastname ?></span>
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
				      	<span class="help-block err" class="form-error" id="gender-error"><?= $formerror->gender ?></span>
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
      						<span class="help-block err" class="form-error" 
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
      						<span class="help-block err form-error" id="residence-error"><?= $formerror->residence ?></span>
      					</div>
    				</div>
    				
    				
				    
				    <div class="form-group">
				      <!-- Address -->
				      <label class="control-label col-sm-1 col-lg-2" for="address">Address</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="address" name="address" value="<?= $formdata->address ?>"
				        placeholder="" class="form-control">
				        <span class="help-block err form-error" id="address-error"><?= $formerror->address ?></span>
				      </div>
				    </div>
				    
				    </fieldset>
				    <fieldset>
				    	<legend></legend>
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
	      						<span class="help-block err form-error" 
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
	      						<span class="help-block err" 
	      						id="collaborative-area-error"><?= $formerror->get("collaborative-area") ?></span>
	      					</div>
    					</div>
				    </fieldset>
				    <fieldset>
				    	<legend></legend>
				    	<div class="form-group">
				      <!-- username -->
				      <label class="control-label col-sm-1 col-lg-2" for="username">Username</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="username" name="username" value="<?= $formdata->username; ?>"
				        placeholder="" class="form-control">
				        <span class="help-block err form-error" id="username-error"><?= $formerror->username ?></span>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- E-mail -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Email</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="email" id="email" name="email" value="<?= $formdata->email ?>"
				        placeholder="" class="form-control" >
				        <span class="help-block err form-error" id="email-error"><?= $formerror->email ?></span>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- password -->
				      <label class="control-label col-sm-1 col-lg-2" for="password">Password</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="password" id="password" name="password" placeholder="" class="form-control">
				        <span class="help-block err form-error" id="password-error"><?= $formerror->password ?></span>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- password confirm  -->
				      <label class="control-label col-sm-1 col-lg-2" for="password-confirm">Confirm Password</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="password" id="password-confirm" name="password-confirm" placeholder="" class="form-control">
				        <span class="help-block err form-error" 
				        id="password-confirm-error"><?= $formerror->get("password-confirm") ?></span>
				      </div>
				    </div>
				    </fieldset>
				    <fieldset>
				    	<legend></legend>
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