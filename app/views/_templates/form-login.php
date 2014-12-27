		<div class="container-fluid" style="margin-top:51px;height: 100%">
			<div class="col-sm-4"></div>
			<div class="col-sm-3 center-block" style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;margin-top: 50px;width: 400px;">
                 <form method="post" class="form-signin" role="form" >
                 		<h2 class="form-signin-heading">Sign in</h2>
                 			<div>
                 				<span class="form-result-error"><?= $data->formResult ?></span>
                 			</div>
                 			
      						<label for="username" class="sr-only">Username:</label>
         						<input type="text" class="form-control" name="username" value="<?= htmlspecialchars($data->username) ?>"id="inputUsername" placeholder="Enter Username or Email" required>
      						<label for="password" class="sr-only">Password:</label>
         						<input type="password" id="inputPassword" name="password" class="form-control" id="firstname" placeholder="Enter Password" required>
                                 <button type="submit" class="btn btn-lg btn-primary btn-block">Sign In</button>
   								<span class="help-block">
                               		New User? <a href="registration">Register here</a><br>
                               		Forgot Password? <a href="#">Click Here</a>
                            	</span>
                 </form>
                 <?php if($data->showActivationOption) { ?>
                 			<form method="post">
                 				<input type="hidden" name="action" value="activation"/>
                 				<button>Send me activation email</button>
                 			</form>
                 <?php } ?>
                           
			</div>

		</div>