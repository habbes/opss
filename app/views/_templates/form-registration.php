			 <div class="form">
			 	<form class="form-horizontal" action='' method="POST" role="form">
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
      						<span class="help-block alert-danger" id="titleErrorMessage"></span>
        					<p class="help-block">This is your title eg Mr Ms Mrs</p>
      					</div>
    				</div>
				    <div class="form-group">
				      <!-- First name -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">First name</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="email" name="firstname" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="firstNameErrorMessage"></span>
				        <p class="help-block">Please provide your first name</p>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- Second name -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Second name</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="secondname" name="secondname" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="secondNameErrorMessage"></span>
				        <p class="help-block">Please provide your second name</p>
				      </div>
				    </div>
 					 <div class="form-group">
				      <!-- Gender -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Gender</label>
				      <div class="col-sm-3 col-md-5">
				      	<label class="radio-inline"><input type="radio" value="1" name="gender">Male</label>
				      	<label class="radio-inline"><input type="radio" value="2" name="gender"></input>Female</label>
				      	<span class="help-block alert-danger" id="genderErrorMessage"></span>
				        <p class="help-block">Please provide your gender</p>
				      </div>
				    </div>
				    <div class="form-group">
      					<!-- Nationality -->
      					<label class="control-label col-sm-1 col-lg-2"  for="username">Country of nationality</label>
      					<div class="col-sm-3 col-md-5">
      						<select class="form-control" title="select your country of nationality" name="nationality">
      							<option>--Select One--</option>
      						</select>
      						<span class="help-block alert-danger" id="nationalityErrorMessage"></span>
        					<p class="help-block">Please select your country of nationality</p>
      					</div>
    				</div>
    				<div class="form-group">
      					<!-- Residence -->
      					<label class="control-label col-sm-1 col-lg-2"  for="username">Country of residence</label>
      					<div class="col-sm-3 col-md-5">
      						<select class="form-control" title="select your country of residence" name="residence">
      							<option>--Select One--</option>
      						</select>
      						<span class="help-block alert-danger" id="residenceErrorMessage"></span>
        					<p class="help-block">Please select your country of residence</p>
      					</div>
    				</div>
    				<div class="form-group">
				      <!-- E-mail -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Email</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="email" id="email" name="email" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="emailErrorMessage"></span>
				        <p class="help-block">Please provide your email</p>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- Address -->
				      <label class="control-label col-sm-1 col-lg-2" for="email">Address</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="address" name="address" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="addressErrorMessage"></span>
				        <p class="help-block">Please provide your address</p>
				      </div>
				    </div>
				    </fieldset>
				    <fieldset>
				    	<legend>Area of specialization</legend>
				    	<div class="form-group">
	      					<!-- Thematic research -->
	      					<label class="control-label col-sm-1 col-lg-2"  for="username">Thematic research</label>
	      					<div class="col-sm-3 col-md-5">
	      						<select class="form-control" title="select your thematic research" name="thematic_area">
	      							<option>A:Poverty,Income Distribution and Food Security</option>
	      							<option>B:Macroeconomics Policies,Investments and Growth</option>
	      							<option>C:Finance and Resource Mobilization</option>
	      							<option>D:Trade and Regional Integration</option>
	      							<option>E:Political Economy,Natural Resource Management and Agricultural Policy Issues</option>
	      							<option>None Applicable</option>
	      						</select>
	      						<span class="help-block alert-danger" id="thematicErrorMessage"></span>
	        					<p class="help-block">Please select your thematic research type</p>
	      					</div>
    					</div>
    					<div class="form-group">
	      					<!-- collaborative research -->
	      					<label class="control-label col-sm-1 col-lg-2"  for="username">Collaborative research</label>
	      					<div class="col-sm-3 col-md-5">
	      						<select class="form-control" title="select your thematic research" name="collaborative_area">
	      							<option>A:Poverty,Income Distribution and Food Security</option>
	      							<option>B:Macroeconomics Policies,Investments and Growth</option>
	      							<option>C:Finance and Resource Mobilization</option>
	      							<option>D:Trade and Regional Integration</option>
	      							<option>E:Political Economy,Natural Resource Management and Agricultural Policy Issues</option>
	      							<option>None Applicable</option>
	      						</select>
	      						<span class="help-block alert-danger" id="collaborativeErrorMessage"></span>
	        					<p class="help-block">Please select your collaborative area type</p>
	      					</div>
    					</div>
				    </fieldset>
				    <fieldset>
				    	<legend>Account access info</legend>
				    	<div class="form-group">
				      <!-- username -->
				      <label class="control-label col-sm-1 col-lg-2" for="username">User name</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="text" id="username" name="username" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="usernameErrorMessage"></span>
				        <p class="help-block">Please provide your username, you will use this user name to access your account</p>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- password -->
				      <label class="control-label col-sm-1 col-lg-2" for="password">Password</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="password" id="password" name="password" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="passwordErrorMessage"></span>
				        <p class="help-block">Please provide your password, you will use this password to access your account</p>
				      </div>
				    </div>
				    <div class="form-group">
				      <!-- password(confirm) -->
				      <label class="control-label col-sm-1 col-lg-2" for="password_confirm">Confirm password</label>
				      <div class="col-sm-3 col-md-5">
				        <input type="password" onkeyup="check()" id="password_confirm" name="password_confirm" placeholder="" class="form-control">
				        <span class="help-block alert-danger" id="password_confirmErrorMessage"></span>
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
	var pass = document.getElementById("password");
	var pass_confirm = document.getElementById("password_confirm");

	function check(){
			if(pass.value != pass_confirm.value){
					pass_confirm.setAttribute("class","alert alert-warning form-control");
					pass_confirm.style.padding = "0px 5px 2px 15px";
					pass_confirm.style.borderColor = "red";
				}else{
					pass_confirm.setAttribute("class","alert alert-success form-control");
					pass_confirm.style.padding = "2px 5px 2px 15px";
					pass_confirm.style.borderColor = "green";
					}
		}
	
</script>