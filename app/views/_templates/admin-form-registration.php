<?php 
$formdata = $data->form;
$formerror = $data->errors;
?>

<div class="form">
			 	<form class="form-horizontal" method="POST" role="form">
			 		<input type="hidden" name="action" value="registration"/>
  					<fieldset>
    				<div class="form-group">
      					<!-- Title -->
      					<label class="control-label col-sm-1 col-lg-2"  for="title">Names</label>
      					<div class="col-sm-3 col-md-1">
      						<select class="form-control" name="title">
      							<option value="">Title</option>
      						<?php foreach($data->titles as $title){	?>
      							<option value="<?=$title?>"
      							<?php if($title == $formdata->title) echo "selected"; ?>
      							><?= $title ?></option>	
      						<?php }	?>
      						</select>
      						<span class="help-block alert-danger" class="form-error" id="title-error"><?= $formerror->title ?></span>
      					</div>
				      <!-- First name -->
				      <div class="col-sm-3 col-md-2">
				        <input type="text" id="firstname" name="firstname" value="<?=$formdata->firstname?>"
				        	placeholder="First name" class="form-control">
				        <span class="help-block alert-danger" class="form-error" id="firstname-error"><?= $formerror->firstname ?></span>
				      </div>
				      <!-- Second name -->
				      <div class="col-sm-3 col-md-2">
				        <input type="text" id="lastname" name="lastname" value="<?=$formdata->lastname?>" 
				        	placeholder="Last name" class="form-control">
				        <span class="help-block alert-danger" class="form-error" id="lastname-error"><?= $formerror->lastname ?></span>
				      </div>
				    </div>
				    </fieldset>
				    <fieldset>
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