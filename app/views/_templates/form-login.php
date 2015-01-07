
<div class="col-sm-4 col-sm-offset-4 panel panel-default" >
	<div class="panel-body">
	    <form method="post" class="form-signin" role="form" >
	       	<div class="form-group">
				<label for="form-username">Username or Email</label>
	         	<input type="text" class="form-control" name="username" value="<?= htmlspecialchars($data->username) ?>" 
	         		id="form-username" placeholder="" required>
	      	</div>
	      	<div class="form-group">
	      		<label for="form-password">Password</label>
	         	<input type="password" id="form-password" name="password" class="form-control" id="firstname" placeholder="" required>		
	      	</div>
	      	<button type="submit" class="btn btn-success btn-block">Sign In</button>	
	      	<span class="help-block">
	      			New User? <a href="registration">Register here</a><br>
	      			Forgot Password? <a href="#">Click Here</a>
			</span>		
		</form>
		<?php if($data->showActivationOption) { ?>
		<form method="post" role="form" class="form">
			<input type="hidden" name="action" value="activation"/>
	        <button class="btn btn-md btn-primary btn-block">Send me activation email</button>
		</form>
		<?php } ?>
	</div>
</div>
