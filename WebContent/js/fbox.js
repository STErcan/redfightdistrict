$(document).ready(function() {		
	// init fbox
	$('a.fbox').fancybox({
		'padding' : 0,
		'titlePosition' : 'over'
	});

	// hoover menu images
	$("li.titel a")
	.mouseover(function() { 
		var img = $(this).find('img');
		var src = $(img).attr("src").replace("_a.png", "_b.png");
		$(img).attr("src", src);
	})
	.mouseout(function() {
		var img = $(this).find('img');
		var src = $(img).attr("src").replace("_b.png", "_a.png");
		$(img).attr("src", src);
	});

});