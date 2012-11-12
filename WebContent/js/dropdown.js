var timeout    = 100;
var closetimer = 0;
var ddmenuitem = 0;

function dropDown_open() {
	dropDown_canceltimer();
	dropDown_close();
	ddmenuitem = $(this).find('ul').css('visibility', 'visible');
	$('iframe').css('visibility', 'hidden');
}

function dropDown_close() {  
	if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');
	$('iframe').css('visibility', 'visible');
}

function dropDown_timer() {
	closetimer = window.setTimeout(dropDown_close, timeout);
}

function dropDown_canceltimer() {
	if(closetimer) {
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

$(document).ready(function() {
	$('#drop_down > li').bind('mouseover', dropDown_open);
	$('#drop_down > li').bind('mouseout',  dropDown_timer);
});

//document.onclick = dropDown_close;