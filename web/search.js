$(document).ready(function(){
	$("#search_text").keyup(function() {
		if($("#search_text").val() != '') {
			$.ajax({
				url: 'search',
				type: 'post',
				data: { query: $("#search_text").val() },
				success: function(response) {
					var html = '';
					//console.log(response);
					
					var json = JSON.parse(response);
					json.forEach(function(entry) {
						html += '<div class="image">' +
									'<a class="image" href="images/' + entry._id + '.' + entry.ext + '">' + 
										'<img src="images/' + entry._id.$id + '-thumb.' + entry.ext + '" /><br />' + 
										'<span class="author">' +  entry.author + '</span><br />' + 
										'<span>' +  entry.title + '</span><br />' + 
									'</a>' + 
								  '</div>';
					});
					
					$(".gallery").html(html);
				}
			});
		} else $(".gallery").html('');
	});
});
