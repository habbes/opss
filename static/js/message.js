
var Message = {
	show : function (id)
	{
		$.getJSON(URL_ROOT + "/messages/ajax/" + id, function(response, status){
			$("#popup-viewer .modal-title").text(response.subject);
			$("#popup-viewer .modal-body").html(response.body);
			$("#popup-viewer").modal({keyboard:false});
		});
		
	}
}