
var Message = {
	show : function (id, subject)
	{
		$("#popup-viewer .modal-title").text(subject);
		$("#popup-viewer .modal-body").load(URL_ROOT + "/messages/ajax/" + id,
		function(response, status, xhr){
			console.log("message load:",status);
			console.log("response:", response);
		});
		$("#popup-viewer").modal({keyboard:false});
	}
}