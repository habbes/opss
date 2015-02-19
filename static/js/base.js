
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

var Message = {
		show : function (id)
		{
			$.getJSON(URL_ROOT + "/messages/ajax/" + id, function(response, status){
				$("#popup-viewer .modal-title").text(response.subject);
				$("#popup-viewer .modal-body").html(response.body);
				$("#popup-viewer").modal({keyboard:false});
				$("#unread-notifications-nav-badge").text(response.unreadCount);
			}).fail(function(){
				showAlertMessage("Failed to retrieve message.", "error");
			});
			
		},	
		
		pollTimeout : null,
		pollXHR : null,
		pollCallback : null,
		
		startPoll : function()
		{
			Message.pollTimeout = setTimeout(function(){
				Message.pollXHR = $.getJSON(URL_ROOT + "/messages/ajax/new", function(response, status){
					var count = response.messages.length;
					if(count > 0){
						showAlertMessage("You have " + count + " new message" + (count>1?"s":"") + ".", "normal");
						
						if(Message.pollCallback){
							Message.pollCallback(response);
						}
					}
					Message.startPoll();
				}).fail(function(){
					console.log("message poll error");
					Message.startPoll();
				});
			}, 3000);
			
		},	
		
		stopPoll : function()
		{
			if(Message.pollXHR) Message.pollXHR.abort();
			clearTimeout(Message.pollTimeout);
		},
	}

var Searcher = {
		
		url : "",
		searchXHR : null,
		target : null,
		searchCallback : null,
		
		search : function(query)
		{
			$(Searcher.target).load(URL_ROOT + "/" + Searcher.url, "q=" + query);
			
		},
}

var PaperSearcher = {
		search : function(query){
			Searcher.target = $("#papers-table-container");
			Searcher.url = "papers/search";
			Searcher.search(query);
		}
}
