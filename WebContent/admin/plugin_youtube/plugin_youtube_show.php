<?php
// requirements
require_once('../ajax_header.php');

$sql = "SELECT * FROM `files` WHERE `check_id` = '".$_GET['mijn_id']."' AND `check_type` = '".$_GET['tabelnaam']."_youtube' ORDER BY `pos` ";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		$meta_array = json_decode($meta,true);
		echo '
		<div class="thumb_yt" id="x_'.$file_id.'">
			<div class="handle"><img src="img/icons/back_16.png" alt="verplaatsen" class="bar" /><img src="img/icons/delete_16.png" alt="verwijderen" class="del" /></div>
				<embed class="yt" src="http://www.youtube.com/v/'.$naam.'?fs=1&amp;hl=nl_NL&amp;rel=0" type="application/x-shockwave-flash" scale="scale" wmode="transparent"></embed>
			<div class="descr"><span>'.$meta_array['title'].'</span></div>
		</div>'."\n";
	}
}
?>
<script language="javascript" type="text/javascript">
<!--//
var show_update;

$(document).ready(function(){

	$('#thumbnails').live('mouseover',function(){
		$(this).sortable({
			revert: 200,
			placeholder: 'placeholder-yt',
			opacity: .85,
			handle : '.bar',
			zIndex: 1000,
			start: function () {
				$('#filesStatus').html('Sorteren...'); 
			},
			stop: function () {
				$('#filesStatus').html(''); 
			},
			update: function () {
				loader_show();
				var order = $(this).sortable('serialize');
				$('#filesStatus').load("plugin_youtube/ajax_verwerking.php?positie=1&"+order); 
				loader_hide();
			}
		}).disableSelection();
	});


	$(".handle img.del").live('click', function(){
		$('#filesStatus').html('Video verwijderen...'); 
		var container = $(this).parent().parent();
		var id = $(container).attr('id');
		$(container).removeClass('thumb').addClass('placeholder').html('');
		$("#prullenbak").addClass('droppable-hover');
		$(container).effect('transfer',{to: "#prullenbak"},500,function() {
			loader_show();
			$(container).hide(200);
			$("#prullenbak").removeClass('droppable-hover');
			kill_target(id);
			var order = $(this).sortable('serialize');
			$('#info').load("plugin_youtube/ajax_verwerking.php?positie=1&"+order); 
			loader_hide();
		});
	});
	
	make_fancy();

});

function kill_target(id) {
	$.ajax({
		url: 'plugin_youtube/plugin_youtube_delete.php',
		data: 'id='+id,
		type: 'GET',
		success: function(feedback){
			$('#filesStatus').html(feedback); 
		},
		error: function(){
			$('#filesStatus').html('FOUT: kan video niet verwijderen!'); 
		}
	});
}

function make_fancy() {
	$('#thumbnails').live('mouseover',function() {
		$(".fancy").fancybox({
			'zoomSpeedIn': 500, 
			'zoomSpeedOut': 300
		});
	});
}

// -->
</script>
