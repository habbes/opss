<div class="col-sm-4 col-sm-offset-4 panel panel-default" >
	<div class="panel-body">
	    <form method="post" class="form-signin" role="form" >
	       	<div class="form-group">
				<label for="form-username">Username or Email</label>
	         	<input type="text" class="form-control" name="username" value="<?= htmlspecialchars($data->username) ?>" 
	         		id="form-username" placeholder="" required>
	      	</div>
	      	<button type="submit" class="btn btn-success btn-block">Send Recovery Email</button>	
	      	<span class="help-block">
	      			Back to <a href="login">Sign in</a><br>
			</span>		
		</form>
	</div>
</div>
