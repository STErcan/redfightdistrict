<?php
// requirements
require_once('../ajax_header.php');

$sql = "SELECT * FROM `files` WHERE `check_id` = '".$_GET['mijn_id']."' AND `check_type` = '".$_GET['tabelnaam']."_galerij' ORDER BY `pos` ";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		$naam_thumb = set_file_name($naam);
		echo '<div class="thumb" id="x_'.$file_id.'">
		<div class="handle"><img src="img/icons/back_16.png" alt="verplaatsen" class="bar" /><img src="img/icons/delete_16.png" alt="verwijderen" class="del" /></div>
		<a rel="galerij" href="../'.$dir.$naam.'" class="fancy img">
			<img src="show_image_admin.php?img=../'.$dir.$naam_thumb.'&amp;crop=110" class="thumbnail" />
		</a>
		<div class="descr"><span id="span_'.$file_id.'" onClick="edit_descr('.$file_id.');">'.$meta.'</span><textarea id="descr_'.$file_id.'" style="display:none;">'.$meta.'</textarea></div>
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
			placeholder: 'placeholder',
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
				$('#filesStatus').load("plugin_galerij/ajax_verwerking.php?positie=1&"+order); 
				loader_hide();
			}
		}).disableSelection();
	});


	$(".handle img.del").live('click', function(){
		$('#filesStatus').html('Afbeelding verwijderen...'); 
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
			$('#info').load("plugin_galerij/ajax_verwerking.php?positie=1&"+order); 
			loader_hide();
		});
	});
	
	make_fancy();

});

function edit_descr(id) {
	$('#filesStatus').html('Omschrijving wijzigen...'); 
	$('#span_'+id).hide();
	$('#descr_'+id).show();
	$('#descr_'+id).focus();
	$('#descr_'+id).blur(function () {



		var descr_content = $(this).val();
		$.ajax({
			url: 'plugin_galerij/plugin_galerij_descr.php',
			data: 'id='+id+'&descr='+descr_content,
			type: 'POST',
			success: function(feedback){
				$('#descr_'+id).hide();
				$('#span_'+id).html(descr_content).show();
				
				loader_show();
				$('#filesStatus').html(feedback); 
				loader_hide();
			},
			error: function(){
				$('#filesStatus').html('FOUT: kan omschrijving niet wijzigen!'); 
			}
		});
		
	});
}

function kill_target(id) {
	$.ajax({
		url: 'plugin_galerij/plugin_galerij_delete.php',
		data: 'id='+id,
		type: 'GET',
		success: function(feedback){
			$('#filesStatus').html(feedback); 
		},
		error: function(){
			$('#filesStatus').html('FOUT: kan afbeelding niet verwijderen!'); 
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
