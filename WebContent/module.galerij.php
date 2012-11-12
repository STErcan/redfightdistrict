<?php
## -- includes
include ("includes/thumbnail.inc.php");

## -- sql
$sql_files = "SELECT * FROM `files` WHERE `check_id` = '".$mijn_id."' AND (`check_type` = 'paginas_galerij' OR `check_type` = 'nieuws_galerij' OR `check_type` = 'agenda_galerij') ORDER BY `pos`, `file_id`";
$resultaat_files = mysql_query($sql_files) or die (mysql_error());
$aantal_files = mysql_num_rows($resultaat_files);

## -- galerij uitvoer
if ($aantal_files > 0) {
	echo'
	<div class="clear"></div>
	';
	for ($i=1; $i<=$aantal_files; $i++) {
		$array_files = (mysql_fetch_array($resultaat_files));
		$img_original = $array_files['dir'].$array_files['naam'];
		$img_thumb = 'show_image.php?img='.$array_files['dir'].set_file_name($array_files['naam']).'&breed=74';
		echo '<div id="foto_thumb"><a class="fbox" rel="galery" href="'.$img_original.'"'.($array_files['meta'] != '' ? ' title="'.$array_files['meta'].'"' : '').'><img src="'.$img_thumb.'" /></a></div>'."\n";
	}	
	echo'
	<div class="clear"></div>
	';
}
?>