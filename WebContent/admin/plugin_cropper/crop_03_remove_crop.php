<?php
#stap na sluiten van fancybox
require_once('config.php');
require_once('../ajax_header.php');
require_once('../../includes/functies.inc.php');

// fotoconfig laden
if ($_POST['check_type'] == 'paginas') {
	# wijzig_paginas
	include('../wijzig_paginas/config.foto.php');
	$settings = $array_fotos_types[$_POST['pagina_type']][$_POST['array_key']];
} else {
	include('../wijzig_'.$_POST['check_type'].'/config.foto.php');
	$settings = $array_fotos[$_POST['array_key']];
}

if (count($settings['thumbs'])>0){
	if ($settings['thumbs'] == false) {
		$thumbnail = false;
	} else {
		$thumbnail = true;
	}
}


if ($_POST['actie']=='accept') {
	// oude foto in dB verwijderen 
	$sql_delete = "DELETE FROM `files` WHERE `check_id` = '".$_POST['check_id']."' AND `check_type` = '".$_POST['check_type']."_foto_".$_POST['array_key']."' ";
	$db->update_sql($sql_delete);
	
	// gegevens in dB plaatsen
	$file_size = filesize($dir.$dir_crop.$_POST['f']);
	$sql = "INSERT INTO `files` (file_id, check_id, check_type, naam, dir, site_id) ";
	$sql .= "VALUES (NULL, '".$_POST['check_id']."', '".$_POST['check_type']."_foto_".$_POST['array_key']."', '".$_POST['f']."', '".$dir_db."', '".$_SESSION['safe_'.$cms_config['token']]['site_id']."')";
	$mijn_id = $db->insert_sql($sql);

	// gecropte file verplaatsen
	@rename($dir.$dir_crop.$_POST['f'], $dir.$_POST['f']);
	
	// thumbs verplaatsen
	echo $dir_preview.$_POST['f'];
	if (count($settings['thumbs'])>0 && $thumbnail == true){		
		// elke thumbje in foreach.
		foreach ($settings['thumbs'] as $key => $value) {
			$thumb_naam = set_file_name($_POST['f'], $value['thumb_ext']);	
			@rename($dir.$dir_crop.$thumb_naam, $dir.$thumb_naam);			
		}
	}
} else {
	// niets doen
}
?>