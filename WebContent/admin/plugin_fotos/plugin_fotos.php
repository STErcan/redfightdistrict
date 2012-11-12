<?php
require_once('plugin_fotos/config.php');
?>
<script type="text/javascript">

	/* hoogte en breedte op 90% berekenen van window */
	var max_height = $(window).height();
	max_height = Math.round(max_height * .9);
	$(window).bind("resize", function(e){
		var max_height = $(window).height();
		max_height = Math.round(max_height * .9);
		$('#fancy_outer').height(max_height);
	});
	var max_width = $(window).width();
	max_width = Math.round(max_width * .9);
	$(window).bind("resize", function(e){
		var max_width = $(window).width();
		max_width = Math.round(max_width * .9);
		$('#fancy_outer').width(max_width);
	}); 

	/* initialiseer fancy box */
	$(document).ready(function() {
		$("a.fbox").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 300 });
		$("a.fbox.iframe").fancybox({ 
			'zoomSpeedIn': 500, 
			'zoomSpeedOut': 300, 
			'width': max_width, 
			'height': max_height, 
			'overlayOpacity': .7,
			'callbackOnShow': toggle_outlines,
			'callbackOnClose': toggle_outlines 
		});
	});
	
	function close_fbox() {
		$.fancybox.close();
		toggle_outlines();
	}
	
	/* opera outline fix */
	function toggle_outlines() {
		if ($.browser.opera) {
			var thumbnail_array = $('#thumbnails span.foto');
			$.each(thumbnail_array, function(){
				if ($(this).hasClass('opera_fix')) {
					$(this).removeClass('opera_fix');
				} else {
					$(this).addClass('opera_fix');
				}
			});
		}
	}
	function delete_pic(foto_id,array_key) {
		loader_show();
		
		$.ajax({
			url: 'plugin_cropper/ajax_verwerking.php',
			data: 'verwijder_foto=1&foto=<?php echo $module_naam; ?>_foto_'+array_key+'&id=<?php echo $_GET['id'] ?>&check_type=<?php echo $_GET['type']; ?>&array_key='+array_key+'&pagina_type=<?php echo $_GET['pagina'];?>',
			type: 'GET',
			success: function(feedback){
				$("#thumb_"+foto_id).addClass('verwijder_thumb',200);
				$("#thumb_"+foto_id+' img').animate({'opacity':'0','height':'100px','width':'120px'},200);
				setTimeout(function() {
					$("#thumb_"+foto_id+' img').remove();
					$("#verwijder_"+foto_id).remove();
					
					$("#thumb_"+foto_id).append('<div class="nopic"><br />Geen afbeelding beschikbaar</div>')
					$("#thumb_"+foto_id+' .nopic').addClass('verwijder_thumb').removeClass('verwijder_thumb',300);
				}, 200);
			},
			error: function(feedback){
				alert(feedback);
			},
			complete: function(){
				loader_hide();
			}
		});
		
	}
	
</script>
<table border="0" cellspacing="0" cellpadding="4" class="form algemeen">
  <tr>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>Klik op de thumbnail om een foto te uploaden en eventueel bij te snijden in het juiste formaat.</td>
  </tr>
    <tr class="sub_lijn">
      <td>
        <div id="thumbnails">
<?php
if (count($array_fotos)>0) {
	$i = 1;
	foreach ($array_fotos as $key => $waarde) {
		// thumbnails uitlezen
		if ($waarde['geen_crop']) {
			$cropper_config = '&amp;geen_crop=1&amp;array_key='.$key;
		} else {
			$cropper_config = '&amp;array_key='.$key;
		}
		if ($_GET['pagina'] == 'paginas'){
			$cropper_config .= '&amp;pagina_type='.$_GET['type'];
		}
		$cropper_config .= '&amp;foto='.$i;
		
		echo '<span class="foto"><a href="plugin_cropper/?check_id='.$mijn_id.'&amp;check_type='.$module_naam.$cropper_config.'" class="fbox iframe" id="uploadlink">'."\n";
		
		$sql = "SELECT * FROM `files` WHERE `check_id` = '".$mijn_id."' AND `check_type` = '".$module_naam."_foto_".$key."' ORDER BY `file_id` DESC LIMIT 0,1 ";
		$result = $db->select($sql);
		$rows = $db->row_count;
		if ($rows == 1) {
			extract($db->get_row($result));
			echo '<span id="thumb_'.$i.'"><img src="show_image_admin.php?img='.$dir_preview.$naam.'&amp;crop=100" /></span>'."\n";
			//echo '<span id="thumb_'.$i.'"><img src="show_image_preview.php?hoog=100&breed=120&img='.$dir_preview.$naam.'" /></span>'."\n";
		} else {
			echo '<span id="thumb_'.$i.'"><div class="nopic"><br />Geen afbeelding beschikbaar</div></span>'."\n";
		}
		
		echo $waarde['descr'].'</a><br />';
		if ($rows == 1) {
			echo '<a href="#" onclick="delete_pic(\''.$i.'\',\''.$key.'\'); return false;" id="verwijder_'.$i.'" class="verwijder">verwijderen</a>';
		}
		echo '</span>'."\n";
		$i= $i+1;		
	}
}
?>
        </div>
      </td>
    </tr>
</table>
