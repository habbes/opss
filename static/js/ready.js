$(function(){
	$("#result-message-container .close").click(function(){
		$(this).parent().hide();
	})
	
	Message.pollCallback = function(response){
		$("#unread-notifications-nav-badge").text(response.unreadCount);
	};
	Message.startPoll();
	
//	$("#papers-search-field").keyup(function(){
//		PaperSearcher.search($(this).val());
//	});
	
	var searchField = $('.search-field');
	window.searchRecords = makeSearcher($(searchField).data('endpoint'), $(searchField).data('url'));
	
	$(searchField).keyup(function(){
		searchRecords($(this).val());
	});
});