$(function(){
	Message.pollCallback = function(response){
		console.log(response);
		$("#unread-notifications-nav-badge").text(response.unreadCount);
	};
	Message.startPoll();
	
	$("#papers-search-field").keyup(function(){
		PaperSearcher.search($(this).val());
	});
});