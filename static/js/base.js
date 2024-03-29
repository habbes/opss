
var URL_ROOT = window.location.origin;
if(typeof URL_SUBDIR !== 'undefined'){
  URL_ROOT += URL_SUBDIR;
}

function showAlertMessage(message, type)
{
	if(type == "error") type = "danger";
	if(type == "normal") type = "info";
	$("#result-message").empty().append(message);
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
						var msg = $("<a></a>").text("You have " + count + " new message" + (count>1?"s":"") + ".")
							.attr("href", URL_ROOT + "/messages/unread");
						showAlertMessage(msg, "normal");
						
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
		
		search : function(query, filters)
		{
			var filterString = "";
			if(filters){
				filterString = "&filters=true";
			}
			if(typeof filters == 'object'){
				for(name in filters){
					filterString += "&"+ encodeURIComponent(name) + "=" + encodeURIComponent(filters[name]);
				}
			}
			else if(typeof filters == 'string'){
				filterString = '&'+filters;
			}
			$(Searcher.target).load(URL_ROOT + "/" + Searcher.url, "q=" + query + filterString);
			
		},
}

var PaperSearcher = {
		search : function(query){
			Searcher.target = $("#papers-table-container");
			Searcher.url = "papers/search";
			Searcher.search(query);
		}
}

var makeSearcher = function(endpoint, url){
	var targetId = "#"+endpoint+"-table-container";
	if(typeof(url) == undefined){
		url = "/" + encodeURIComponent(endpoint) + "/search";
	}
	

	
	return function(query){
		var filters = {};
		$.each($('.records-search-filters-container .form-control'),function(index, input){
			console.log('input', input);
			filters[$(input).attr('name')] = $(input).val();
		});
		console.log('filters parsed', filters);
		Searcher.target = targetId;
		Searcher.url = url;
		Searcher.search(query, filters);
	}
	
}
