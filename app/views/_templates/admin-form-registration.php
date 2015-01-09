<?php 
$formdata = $data->form;
$formerror = $data->errors;
?>

<div class="form row">
	<form class="form-horizontal" method="post" role="form">
		<input type="hidden" name="action" value="registration"/>
		<!-- first col -->
		<div class="col-sm-6 col-sm-offset-3 col-xs-12">
			<fieldset>
				<legend class="col-sm-offset-1">Personal Info</legend>
				<div class="form-group row combined-fields">
					<div class="col-sm-2 col-sm-offset-1 combined-fields-item" style="padding-right:0px">
	      				<select class="form-control" name="title" placeholder="Title">
	      					<option value="">Title</option>
	      					<?php foreach($data->titles as $title){	?>
	      					<option value="<?=$title?>"
	      					<?php if($title == $formdata->title) echo "selected"; ?>
	      							><?= $title ?></option>	
	      					<?php }	?>
	      				</select>
	      				<span class="help-block text-danger form-error" id="title-error"><?= $formerror->title ?></span>
	      			</div>
	      			
	      			<!-- First name -->
					<div class="col-sm-4 combined-fields-item" style="padding-left: 0px;padding-right:0px">
						<input type="text" id="firstname"
							name="firstname" value="<?=$formdata->firstname?>"
							placeholder="First name" class="form-control">
						<span class="help-block text-danger form-error" id="firstname-error"><?= $formerror->firstname ?></span>
					</div>
					
					<!-- Last name -->
					<div class="col-sm-4 combined-fields-item" style="padding-left: 0px">
						<input type="text" id="lastname" name="lastname"
								value="<?=$formdata->lastname?>" 
					        	placeholder="Last name" class="form-control">
					    <span class="help-block text-danger form-error" id="lastname-error"><?= $formerror->lastname ?></span>
					</div>
				</div>
				
				<fieldset>
				<legend class="col-sm-offset-1">Account Access Info</legend>
				<div class="form-group">
					<!-- username -->
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="text" id="username" name="username" value="<?= $formdata->username; ?>"
				        placeholder="Enter your Username" class="form-control">
				        <span class="help-block text-danger form-error" id="username-error"><?= $formerror->username ?></span>
				    </div>
				</div>
				<div class="form-group">
				      <!-- E-mail -->
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="email" id="email" name="email" value="<?= $formdata->email ?>"
				        placeholder="Enter your Email address" class="form-control" >
				        <span class="help-block text-danger form-error" id="email-error"><?= $formerror->email ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<!-- password -->
					<div class="col-sm-10 col-sm-offset-1">
				        <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control">
				        <span class="help-block text-danger form-error" id="password-error"><?= $formerror->password ?></span>
					</div>
				</div>
		
				<div class="form-group">
					<!-- password confirm  -->
				    <div class="col-sm-10 col-sm-offset-1">
				    	<input type="password" id="password-confirm" name="password-confirm" class="form-control"
				    		placeholder="Repeat Password">
				        <span class="help-block text-danger form-error" 
				        id="password-confirm-error"><?= $formerror->get("password-confirm") ?></span>
				     </div>
				</div>
			</fieldset>
			
			<fieldset>
    		<div class="form-group">
      		<!-- Button -->
      			<div class="align-center">
        			<input type="submit" class="btn btn-success inline" value="Proceed With Registration"/>
     			</div>
    		</div>
    		</fieldset>
				
				
		</div>
		
		<div class="clearfix"></div>
		
		
	</form>
</div>


<script>
	
	var pass = $("#password");
	var passConfirm = $("#password-confirm");
	passConfirm.on("keyup", function(){
		if(pass.val() != $(this).val()){
			$(this).parents(".form-group").addClass("has-error");
		}
		else {
			$(this).parents(".form-group").removeClass("has-error");
		}
	});
</script>
