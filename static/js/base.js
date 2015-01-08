
var URL_ROOT = window.location.origin + "/aerc_opss";

function showAlertMessage(message, type)
{
	if(type == "error") type = "danger";
	if(type == "normal") type = "info";
	$("#result-message").text(message);
	$("#result-message-container").removeClass("alert-danger")
		.removeClass("alert-info")
		.removeClass("alert-success")
		.addClass("alert-" + type)
		.show();
}