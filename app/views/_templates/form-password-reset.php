<?php 
$formdata = $data->form or $formdata = new DataObject();
$formerror = $data->errors or $formerror = new DataObject();
?>
<div class="col-sm-4 col-sm-offset-4 panel panel-default" >
	<div class="panel-body">
	    <form method="post" class="form-signin passForm" role="form" >
	       	<div class="form-group">
	         	<input type="text" class="form-control" name="username" value="<?= escape($formdata->username) ?>" 
	         		id="form-username" placeholder="Username or Email" required>
	         	<span class="text-danger form-error help-block"><?= $formerror->username ?></span>
	      	</div>
	      	<div class="form-group">
	         	<input type="password" id="form-password" name="password" class="form-control passwordCheck" id="firstname" placeholder="Enter new password" required>		
	      		<span class="text-danger form-error help-block"><?= $formerror->password?></span>
	      		<div class="passwordFeedback"><span></span><div class="strengthBarWrapper"></div></div>
	      	</div>
	      		<div class="form-group">
	         	<input type="password" id="form-confirm-password" name="confirm-password" class="form-control" placeholder="Confirm Password" required>		
	      		<span class="text-danger form-error help-block"><?= $formerror->get('confirm-password') ?></span>
	      	</div>
	      	<button type="submit" class="btn btn-success btn-block">Sign In</button>	
	      	<span class="help-block">
	      			Back to <a href="login">Sign In</a><br>
			</span>		
		</form>
	</div>
</div>
