<?php 
$formdata = $data->form or $formdata = new DataObject();
$formerror = $data->errors or $formerror = new DataObject();
?>

<div class="form row">
	<form class="form-horizontal" method="post"  enctype="multipart/form-data" role="form">
		<input type="hidden" name="action" value="registration"/>
		<!-- first col -->
		<div class="col-sm-6 col-xs-12">
			<fieldset>
				<legend>Personal Info</legend>
				<div class="form-group">
					<!-- Profile Pic -->
					<div class="col-sm-10">
						<label>Profile Photo</label>
						<input type="file" name="photo" title="Profile Photo">
						<span class="help-block text-danger form-error" id="photo-error"><?= escape($formerror->photo)?></span>
					</div>
				</div>
				<div class="form-group row combined-fields">
					<div class="col-sm-2 combined-fields-item" style="padding-right:0px">
	      				<select class="form-control" name="title" placeholder="Title">
	      					<option value="">Title</option>
	      					<?php foreach($data->titles as $title){	?>
	      					<option value="<?=$title?>"
	      					<?php if($title == $formdata->title) echo "selected"; ?>
	      							><?= escape($title) ?></option>	
	      					<?php }	?>
	      				</select>
	      				<span class="help-block text-danger form-error" id="title-error"><?= escape($formerror->title) ?></span>
	      			</div>
	      			
	      			<!-- First name -->
					<div class="col-sm-4 combined-fields-item" style="padding-left: 0px;padding-right:0px">
						<input type="text" id="firstname"
							name="firstname" value="<?= escape($formdata->firstname)?>"
							placeholder="First name" class="form-control">
						<span class="help-block text-danger form-error" id="firstname-error"><?= escape($formerror->firstname) ?></span>
					</div>
					
					<!-- Last name -->
					<div class="col-sm-4 combined-fields-item" style="padding-left: 0px">
						<input type="text" id="lastname" name="lastname"
								value="<?= escape($formdata->lastname) ?>" 
					        	placeholder="Last name" class="form-control">
					    <span class="help-block text-danger form-error" id="lastname-error"><?= escape($formerror->lastname) ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<!-- Gender -->
			    	<div class="col-sm-3 col-md-5">
			      		<label class="radio-inline"><input type="radio" value="<?= UserGender::MALE?>" name="gender"
			      		<?php if($formdata->gender == UserGender::MALE) echo "checked"; ?> >Male</label>
			      		<label class="radio-inline"><input type="radio" value="<?= UserGender::FEMALE?>" name="gender"
			      		<?php if($formdata->gender == UserGender::FEMALE) echo "checked"; ?> >Female</label>
			      		<span class="help-block text-danger form-error" id="gender-error"><?= escape($formerror->gender) ?></span>
			      	</div>
			    </div>
			    
			    <div class="form-group">
	      			<!-- Nationality -->
	      			<div class="col-sm-10">
	      				<select class="form-control" id="nationality" title="select your country of nationality" name="nationality">
	      					<option value="">Select Country of Nationality</option>
	      					<?php foreach($data->countries as $country){ ?>
	      						<option value="<?=$country?>"
	      						<?php if($country == $formdata->nationality) echo "selected"; ?> ><?= escape($country) ?></option>
	      					<?php } ?>
	      				</select>
	      				<span class="help-block text-danger form-error" 
	      					id="nationality-error"><?= escape($formerror->nationality) ?></span>
	      			</div>
	    		</div>
	    		
	    		<div class="form-group">
	      		<!-- Residence -->
	      			<div class="col-sm-10">
	      				<select class="form-control" title="select your country of residence" name="residence">
	      					<option value="">Select Country of Residence</option>
	      					<?php foreach($data->countries as $country){ ?>
	      					<option value="<?=$country?>"
	      						<?php if($country == $formdata->residence) echo "selected"; ?> ><?= escape($country) ?></option>
	      					<?php } ?>
	      				</select>
	      				<span class="help-block text-danger form-error" id="residence-error"><?= escape($formerror->residence) ?></span>
	      			</div>
	    		</div>
	    				
				<div class="form-group">
				<!-- Address -->
					<div class="col-sm-10">
						<input type="text" id="address" name="address" value="<?= escape($formdata->address) ?>"
					        placeholder="Enter your Address" class="form-control">
					    <span class="help-block text-danger form-error" id="address-error"><?= escape($formerror->address) ?></span>
					</div>
				</div>
			</fieldset>
			
			
			<fieldset>
				<legend>Area of Specialization</legend>
				<div class="form-group">
	      		<!-- Thematic research -->
	      			<div class="col-sm-10">
	      				<select class="form-control" title="select your thematic research area" name="thematic-area">
	      					<option value="">Thematic Research</option>
	      				<?php foreach($data->researchAreaValues as $area ){?>
	      					<option value="<?=$area?>"
	      						<?php if($area == $formdata->get("thematic-area")) echo "selected"; ?>
	      							><?= escape($data->researchAreaNames[$area]) ?></option>
	      					<?php } ?>
	      				</select>
	      				<span class="help-block text-danger form-error" 
	      					id="thematic-area-error"><?= escape($formerror->get("thematic-area")) ?></span>
	      			</div>
    			</div>
    			<div class="form-group">
	      					<!-- collaborative research -->
	      			<div class="col-sm-10">
	      				<select class="form-control" title="select your collaborative research area" name="collaborative-area">
	      					<option value="">Collaborative Research</option>
	      				<?php foreach($data->researchAreaValues as $area ){?>
	      					<option value="<?=$area?>"
	      					<?php if($area == $formdata->get("collaborative-area")) echo "selected"; ?>
	      						><?= escape($data->researchAreaNames[$area]) ?></option>
	      				<?php } ?>
	      				</select>
	      				<span class="help-block text-danger form-error" 
	      					id="collaborative-area-error"><?= escape($formerror->get("collaborative-area")) ?></span>
	      			</div>
    			</div>
			</fieldset>
	
		</div>
		<!-- end first col -->
		
		<!-- 2nd col -->
		<div class="col-sm-6 col-xs-12">
			<fieldset>
				<legend class="col-sm-offset-2">Account Access Info</legend>
				<div class="form-group">
				      <!-- E-mail -->
				    <div class="col-sm-10 col-sm-offset-2">
				    	<input type="email" id="email" name="email" value="<?= escape($formdata->email) ?>"
				        placeholder="Enter your Email address" class="form-control" >
				        <span class="help-block text-danger form-error" id="email-error"><?= escape($formerror->email) ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<!-- current password  -->
					<div class="col-sm-10 col-sm-offset-2">
				        <input type="password" id="current-password" name="current-password" placeholder="Enter Current Password" 
				        	class="form-control">
				        <span class="help-block text-danger form-error" 
				        	id="current-password-error"><?= escape($formerror->get("current-password")) ?></span>
					</div>
				</div>
				
				<div class="form-group">
					<!-- new password -->
					<div class="col-sm-10 col-sm-offset-2">
				        <input type="password" id="password" name="password" placeholder="Enter New Password" class="form-control">
				        <span class="help-block text-danger form-error" id="password-error"><?= escape($formerror->password) ?></span>
					</div>
				</div>
		
				<div class="form-group">
					<!-- password confirm  -->
				    <div class="col-sm-10 col-sm-offset-2">
				    	<input type="password" id="password-confirm" name="password-confirm" class="form-control"
				    		placeholder="Repeat Password">
				        <span class="help-block text-danger form-error" 
				        id="password-confirm-error"><?= escape($formerror->get("password-confirm")) ?></span>
				     </div>
				</div>
			</fieldset>
		</div>
		<!-- end 2nd col -->
		<div class="clearfix"></div>
		<fieldset>
    		<div class="form-group">
      		<!-- Button -->
     			<div class="align-center">
        			<input type="submit" class="btn btn-success inline" value="Save Changes"/>
        			<a href="<?= URL_ROOT?>/profile" class="link btn btn-default">Cancel</a>
     			</div>
    		</div>
    	</fieldset>
		
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
