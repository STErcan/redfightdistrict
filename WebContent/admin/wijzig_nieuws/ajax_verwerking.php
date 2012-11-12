<?php
// requirements
require_once('../ajax_header.php');
require_once('config.php');


// posities verwerken
if ($_GET['positie'] == 1) {
	// array uitlezen
	if (count($_GET['item'])>1) {
		foreach ($_GET['item'] as $key => $waarde) {
			$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$key."' WHERE `pagina_id` = '".$waarde."' LIMIT 1";
			$db->update_sql($sql);
		}
	}
	$melding = 'Posities zijn gewijzigd.';
}


// verwijderen
if ($_GET['verwijder'] == 1) {
	// informatie ophalen
	$sql = "SELECT `type` FROM `".$tabelnaam."` WHERE `pagina_id` = '".$_GET['id']."' LIMIT 0,1";
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows == 1) {
		extract($db->get_row($result));
	}

	// item verwijderen
	$sql = "DELETE FROM `".$tabelnaam."` WHERE `pagina_id` = '".$_GET['id']."' LIMIT 1 ";
	$db->update_sql($sql);
	
	// files verwijderen
	include('config.foto.php');
	$settings = $array_fotos;

	if (count($settings)>0) {
		foreach ($settings as $key => $subarray) {
			// thumbs
			if (count($subarray['thumbs'])>0) {
				foreach ($subarray['thumbs'] as $thumbkey => $thumbwaarde) {
					if (count($subarray['thumbs'])>0) {
						$array_delete_files[$key][$thumbkey] = $thumbwaarde['thumb_ext'];
					}
				}
			}
			
		}
	}

	
	// delete crop files
	$sql = "
	SELECT `naam`, `dir`, SUBSTRING(`check_type`,13,100) AS `crop_key` 
	FROM `files` WHERE `check_id` = '".$_GET['id']."' 
	AND `check_type` LIKE 'nieuws_foto_%'
	";
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows >= 1) {
		for ($i=1; $i<=$rows; $i++) {
			extract($db->get_row($result));
			// main file
			unlink("../../".$dir.$naam)."\n";
			// delete thumbs
			if (count($array_delete_files[$crop_key])>0) {
				foreach ($array_delete_files[$crop_key] as $key => $thumb_extention) {
					$thumb_file_name = set_file_name($naam, $thumb_extention);
					unlink("../../".$dir.$thumb_file_name)."\n";
				}
			}
		}
	}
	
	// delete gallery files
	$sql = "
	SELECT `naam`, `dir`
	FROM `files` WHERE `check_id` = '".$_GET['id']."' 
	AND `check_type` = 'nieuws_galerij'
	";
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows >= 1) {
		for ($i=1; $i<=$rows; $i++) {
			extract($db->get_row($result));
			// main file
			unlink("../../".$dir.$naam)."\n";
			
			// delete thumbs
			$thumb_file_name = set_file_name($naam);
			unlink("../../".$dir.$thumb_file_name)."\n";
		}
	}
	
	// delete regular files
	$sql = "
	SELECT `naam`, `dir`
	FROM `files` WHERE `check_id` = '".$_GET['id']."' 
	AND `check_type` = 'nieuws'
	";
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows >= 1) {
		for ($i=1; $i<=$rows; $i++) {
			extract($db->get_row($result));
			// main file
			unlink("../../".$dir.$naam)."\n";
		}
	}
	
	// delete file entries from dB
	$sql_files = "DELETE FROM `files` 
	WHERE `check_id` = '".$_GET['id']."' 
	AND (
		`check_type` LIKE 'nieuws_foto_%'
		OR `check_type` = 'nieuws_galerij'
		OR `check_type` = 'nieuws'
	)
	";
	$db->update_sql($sql_files);
	
	$melding = $item_pre.' '.$item_titel.' is verwijderd.';
}


// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."` ";
$db->update_sql($sql);
?>