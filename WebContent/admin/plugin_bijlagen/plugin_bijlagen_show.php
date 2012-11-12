<?php
// requirements
require_once('../ajax_header.php');

$sql = "SELECT * FROM `files` WHERE `check_id` = '".$_GET['mijn_id']."' AND `check_type` = '".$_GET['tabelnaam']."' ORDER BY `pos` ";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		$img_icon = file_icon($naam);
		echo '<div class="file" id="x_'.$file_id.'">
		<div class="item">'.$img_icon.$naam.'</div>
		<div class="handle"><img src="img/icons/up_16.png" alt="verplaatsen" class="bar" /><img src="img/icons/delete_16.png" alt="verwijderen" class="del" /></div>
		</div>'."\n";
	}
} else {
	echo '';
}
?>
<script language="javascript" type="text/javascript">
<!--//
var show_update;

$(document).ready(function(){
	var activespan = '';

	$('#thumbnails').live('mouseover',function(){
		$(this).sortable({
			revert: 200,
			placeholder: 'placeholder-files',
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
				$('#filesStatus').load("plugin_bijlagen/ajax_verwerking.php?positie=1&"+order); 
				loader_hide();
			}
		}).disableSelection();
	});
	
	$(".handle img.del").live('click', function(){
		var container = $(this).parent().parent();
		var id = $(container).attr('id');
		$(container).removeClass('file').addClass('placeholder-files').html('');
		$("#prullenbak").addClass('droppable-hover');
		$(container).effect('transfer',{to: "#prullenbak"},300,function() {
			loader_show();
			$(container).hide(200);
			$("#prullenbak").removeClass('droppable-hover');
			kill_target(id);
			var order = $(this).sortable('serialize');
			$('#info').load("plugin_bijlagen/ajax_verwerking.php?positie=1&"+order); 
			loader_hide();
		});
	});

});

function kill_target(id) {
	$.ajax({
		url: 'plugin_bijlagen/plugin_bijlagen_delete.php',
		data: 'id='+id,
		type: 'GET',
		success: function(feedback){
			$('#filesStatus').html(feedback); 
		},
		error: function(){
			$('#filesStatus').html('FOUT: kan bestand niet verwijderen!'); 
		}
	});
}
// -->
</script>
