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
      						<option>--Select One--</option>
      							<option>Doctor</option>
      							<option>Sir</option>
      							<option>Teacher</option>
      						</select>
      						<span class="help-block alert-danger" class="form-error" id="title-error"></span>
        					<p class="help-block">This is your title eg Mr Ms Mrs</p>
      					</div>
    				</div>
    				
				    <div class="form-group">
				      <!-- First name -->
				      <label class="control-label col-sm-1 col-lg-2" for="firstname">First name</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="firstname" name="firstname" placeholder="" class="form-control">
				        <span class="help-block alert-danger" class="form-error" id="firstname-error"></span>
				        <p class="help-block">Please provide your first name</p>
				      </div>
				    </div>
				    
				    <div class="form-group">
				      <!-- Second name -->
				      <label class="control-label col-sm-1 col-lg-2" for="lastname">Last name</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="lastname" name="lastname" placeholder="" class="form-control">
				        <span class="help-block alert-danger" class="form-error" id="lastname-error"></span>
				        <p class="help-block">Please provide your second name</p>
				      </div>
				    </div>
				    
 					 <div class="form-group">
				      <!-- Gender -->
				      <label class="control-label col-sm-1 col-lg-2" for="gender">Gender</label>
				      <div class="col-sm-3 col-md-5">
				      	<label class="radio-inline"><input type="radio" value="male" name="gender">Male</label>
				      	<label class="radio-inline"><input type="radio" value="female" name="gender"></input>Female</label>
				      	<span class="help-block alert-danger" class="form-error" id="gender-error"></span>
				        <p class="help-block">Please provide your gender</p>
				      </div>
				    </div>
				    
				    <div class="form-group">
      					<!-- Nationality -->
      					<label class="control-label col-sm-1 col-lg-2"  for="nationality">Country of nationality</label>
      					<div class="col-sm-3 col-md-5">
      						<select class="form-control" id="nationality" title="select your country of nationality" name="nationality">
      							<option>--Select One--</option>
      							<?php foreach(file("app/sys_data/countries-en",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $country){ ?>
      								<option><?=$country?></option>
      							<?php } ?>
      						</select>
      						<span class="help-block alert-danger" class="form-error" id="nationality-error"></span>
        					<p class="help-block">Please select your country of nationality</p>
      					</div>
    				</div>
    				
    				<div class="form-group">
      					<!-- Residence -->
      					<label class="control-label col-sm-1 col-lg-2"  for="residence">Country of residence</label>
      					<div class="col-sm-3 col-md-5">
      						<select class="form-control" title="select your country of residence" name="residence">
      							<option>--Select One--</option>
      							<?php foreach(file("app/sys_data/countries-en",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $country){ ?>
      								<option><?=$country?></option>
      							<?php } ?>
      						</select>
      						<span class="help-block alert-danger form-error" id="residence-error"></span>
        					<p class="help-block">Please select your country of residence</p>
      					</div>
    				</div>
    				
    				<div class="form-group">
				      <!-- E-mail -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Email</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="email" id="email" name="email" placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" id="email-error"></span>
				        <p class="help-block">Please provide your email</p>
				      </div>
				    </div>
				    
				    <div class="form-group">
				      <!-- Address -->
				      <label class="control-label col-sm-1 col-lg-2" for="address">Address</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="address" name="address" placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" id="address-error"></span>
				        <p class="help-block">Please provide your address</p>
				      </div>
				    </div>
				    
				    </fieldset>
				    <fieldset>
				    	<legend>Area of specialization</legend>
				    	<div class="form-group">
	      					<!-- Thematic research -->
	      					<label class="control-label col-sm-1 col-lg-2"  for="thematic-area">Thematic research</label>
	      					<div class="col-sm-3 col-md-5">
	      						<select class="form-control" title="select your thematic research" name="thematic-area">
	      							<option>A:Poverty,Income Distribution and Food Security</option>
	      							<option>B:Macroeconomics Policies,Investments and Growth</option>
	      							<option>C:Finance and Resource Mobilization</option>
	      							<option>D:Trade and Regional Integration</option>
	      							<option>E:Political Economy,Natural Resource Management and Agricultural Policy Issues</option>
	      							<option>None Applicable</option>
	      						</select>
	      						<span class="help-block alert-danger form-error" id="thematic-area-error"></span>
	        					<p class="help-block">Please select your thematic research type</p>
	      					</div>
    					</div>
    					<div class="form-group">
	      					<!-- collaborative research -->
	      					<label class="control-label col-sm-1 col-lg-2"  for="collaborative-area">Collaborative research</label>
	      					<div class="col-sm-3 col-md-5">
	      						<select class="form-control" title="select your thematic research" name="collaborative_area">
	      							<option>A:Poverty,Income Distribution and Food Security</option>
	      							<option>B:Macroeconomics Policies,Investments and Growth</option>
	      							<option>C:Finance and Resource Mobilization</option>
	      							<option>D:Trade and Regional Integration</option>
	      							<option>E:Political Economy,Natural Resource Management and Agricultural Policy Issues</option>
	      							<option>None Applicable</option>
	      						</select>
	      						<span class="help-block alert-danger" id="collaborative-area-error"></span>
	        					<p class="help-block">Please select your collaborative area type</p>
	      					</div>
    					</div>
				    </fieldset>
				    <fieldset>
				    	<legend>Account access info</legend>
				    	<div class="form-group">
				      <!-- username -->
				      <label class="control-label col-sm-1 col-lg-2" for="username">Username</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="username" name="username" placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" id="username-error"></span>
				        <p class="help-block">Please provide your username, you will use this user name to access your account</p>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- password -->
				      <label class="control-label col-sm-1 col-lg-2" for="password">Password</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="password" id="password" name="password" placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" id="password-error"></span>
				        <p class="help-block">Please provide your password, you will use this password to access your account</p>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- password confirm  -->
				      <label class="control-label col-sm-1 col-lg-2" for="password-confirm">Confirm Password</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="password" id="password-confirm" name="password-confirm" placeholder="" class="form-control">
				        <span class="help-block alert-danger form-error" id="password-confirm-error"></span>
				        <p class="help-block">Please confirm your password</p>
				      </div>
				    </div>
				    </fieldset>
				    <fieldset>
				    	<legend>Completion</legend>
    					<div class="form-group">
      					<!-- Button -->
      						<div class="col-sm-offset-1">
        						<button type="submit" class="btn btn-success inline">Proceed</button>
        						<button style="margin-left: 280px" type="reset" class="btn btn-fail">Clear</button>
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
			$(this).addClass("alet-warning").removeClass("alert-success");
		}
		else {
			$(this).addClass("alert-success").removeClass("alert-warning");
		}
	});
</script>
</div>
</div>