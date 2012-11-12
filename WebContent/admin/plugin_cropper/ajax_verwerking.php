<?php
// requirements
require_once('../ajax_header.php');

// fotoconfig laden
if ($_GET['pagina_type'] == 'paginas') {
	# wijzig_paginas
	include('../wijzig_paginas/config.foto.php');
	$settings = $array_fotos_types[$_GET['check_type']][$_GET['array_key']];
} else {
	include('../wijzig_'.$_GET['check_type'].'/config.foto.php');
	$settings = $array_fotos[$_GET['array_key']];
}


if ($_GET['verwijder_foto'] == 1) {
	// item verwijderen
	$sql = "SELECT * FROM `files` WHERE `check_type` = '".$_GET['foto']."' AND `check_id` = '".$_GET['id']."' LIMIT 1  ";
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows == 1)  {
		extract($db->get_row($result));
		unlink("../../".$dir.$naam)."\n";
		
		// thumbs deleten
		if (count($settings['thumbs']) > 0) {
			foreach ($settings['thumbs'] as $key => $value) {
				$thumb_naam = set_file_name($naam, $value['thumb_ext']);
				unlink("../../".$dir.$thumb_naam)."\n";
			}
		}

		
		// delete in DB
		$sql_delete = "DELETE FROM `files` WHERE `file_id` = ".$file_id." LIMIT 1 ";
		$db->update_sql($sql_delete);

	}

	$melding = 'De foto is verwijderd.';
}


?>