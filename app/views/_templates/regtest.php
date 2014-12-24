<html>
<head>
<title>Registration</title>
<style>
body {
	font-family:verdana;
	font-size:13px;
}
</style>
</head>
<body>
	<div>
		<span><?php echo $data->resultMessage; ?></span>
	</div>
	<form method="post">
	Title <select name="title">
		<option>Mr.</option>
		<option>Mrs.</option>
		<option>Dr.</option>
	</select><br>
	First Name <input type="text" name="first"/><br>
	Last Name <input type="text" name="last"/><br>
	Gender <input type="radio" name="gender" value="<?= UserGender::MALE ?>" />Male
	<input type="radio" name="gender" value="<?= UserGender::FEMALE ?>" /> Female <br>
	Username <input type="text" name="username"/><br>
	Email <input type="email" name="email"/><br>
	Password <input type="password" name="password"/><br>
	Country of Residence <input type="residence" name="residence"/><br>
	Country of Nationality <input type="text" name="nationality"/><br>
	Address <input type="text" name="address"/><br>
	
	<button>Submit</button>
		
	</form>
</body>

</html>