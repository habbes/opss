//PASSWORD VALIDATION

var pass_re = /^[a-zA-Z0-9`~!@#\$%\^&\*\(\)\-_\+=\[\{\]\}\'\";:\\\|,<\.>\/\? ]*$/;

var PASS_VERY_STRONG = 4;
var PASS_STRONG = 3;
var PASS_MEDIUM = 2;

function passwordStrength(pass){
	if (passwordVeryStrong(pass)) return 4;
	if (passwordStrong(pass)) return 3;
	if (passwordMedium(pass)) return 2;
	return 1;
}

function passwordValid(pass){
	return pass_re.test(pass);
}

function passwordEmpty(pass){
	return pass.length == 0;
}

function passwordShort(pass){
	return pass.length < 6;
}

function passwordLong(pass){
	return pass.length > 50;
}

function passwordVeryStrong(pass){
	var res = [
		/.*(?=.{12,})(?=.*[a-z](?=.*[a-z]))(?=.*[A-Z](?=.*[A-Z]))(?=.*\d(?=.*\d))/,
		/.*(?=.{12,})(?=.*[a-z](?=.*[a-z]))(?=.*[A-Z](?=.*[A-Z]))(?=.*[\W_](?=.*[\W_]))/,
		/.*(?=.{14,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])/,
		];

	for(var i = 0; i < res.length; i++){
		if(res[i].test(pass)) return true;
	}
	return false;
}

function passwordStrong(pass){
	var res = [
		/.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])/,
		/.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d(?=.*\d))/,
		/.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_](?=.*[\W_]))/
		];
	for(var i = 0; i < res.length; i++){
		if(res[i].test(pass)) return true;
	}
	return false;
}

function passwordMedium(pass){
	var res = [
		/.*(?=.{7,})(?=.*[a-z])(?=.*[A-Z])/,
		/.*(?=.{7,})(?=.*\[a-zA-Z])(?=.*[\W_])/,
		/.*(?=.{7,})(?=.*[a-zA-Z])(?=.*\d)/
		];
	for(var i = 0; i < res.length; i++){
		if(res[i].test(pass)) return true;
	}
	return false;
}

$(document).ready(function(){
	$(".passwordFeedback").each(function(){
		var passField = $(this).siblings("input[name=password]").first();
		passField.feedback = $(this);
		$(passField).keyup(function(){
			var pass = $(this).val();
			var feedback = $(this).siblings(".passwordFeedback").first();
			$(feedback).css("display", "block");
			var ftext = $(feedback).children("span").first();
			var fstrength = $(feedback).children(".strengthBarWrapper").first();
			if(!passwordValid(pass)){
				$(ftext).text("Invalid");
				$(fstrength).css("width", "20%").css("background-color","red");
			}
			else if(passwordShort(pass)){
				$(ftext).text("Too Short");
				$(fstrength).css("width", "20%").css("background-color","red");
			}
			else if(passwordLong(pass)){
				$(ftext).text("Too Long");
				$(fstrength).css("width", "20%").css("background-color","red");
			}
			else {
				var strength = passwordStrength(pass);
				switch(strength){
				case PASS_VERY_STRONG:
					$(ftext).text("Very Strong");
					$(fstrength).css("width", "100%").css("background-color","green");
					break;
				case PASS_STRONG:
					$(ftext).text("Strong");
					$(fstrength).css("width", "80%").css("background-color","green");
					break;
				case PASS_MEDIUM:
					$(ftext).text("Medium");
					$(fstrength).css("width", "60%").css("background-color","orange");
					break;
				default:
					$(ftext).text("Weak");
					$(fstrength).css("width", "40%").css("background-color","red");
				}
			}
			
		})
	});
	//forces user to enter a strong password
	$(".passForm").submit(function(){
		var passField = $(this).find("input[name=password]");
		var pass = $(passField).val();
		
		if(!passwordStrong(pass)){
			
			$(passField).siblings(".form-error").text("Please use stronger password.").show();
			return false;
		}
		return true;
	}
			
	);

	
});

