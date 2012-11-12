<?php
include('../ajax_header.php');
include('config.php');


// posities verwerken
if ($_GET['positie'] == 1) {
	// array uitlezen
	if (count($_GET['item'])>1) {
		foreach ($_GET['item'] as $key => $waarde) {
			$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$key."' WHERE `".$prefix."id` = '".$waarde."' LIMIT 1";
			$affected_rows = $db->update_sql($sql);
		}
	}
}


// verwijderen
if ($_GET['verwijder'] == 1) {
	// item verwijderen
	$sql = "DELETE FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 1 ";
	$affected_rows = $db->update_sql($sql);
	$melding = $item_pre.' '.$item_titel.' is verwijderd.';
}


// sites toewijzen
if ($_GET['sites'] == 1) {
	// bestaat de waarde al? dan updaten
	$sql_check = "SELECT * FROM `".$tabelnaam."_2_sites` WHERE `user_id` = '".$_GET['user_id']."' AND `site_id` = '".$_GET['site_id']."' LIMIT 0,1";
	$result_check = $db->select($sql_check);
	$rows_check = $db->row_count;
	if ($rows_check == 1) {
		// ja 
		if ($_GET['checked'] == 'false') {
			// verwijderen
			$sql = "DELETE FROM `".$tabelnaam."_2_sites` WHERE `user_id` = '".$_GET['user_id']."' AND `site_id` = '".$_GET['site_id']."' LIMIT 1";
			$affected_rows = $db->update_sql($sql);
		}
	
	} else {
		// nee nog niet
		if ($_GET['checked'] == 'true') {
			// nee nog niet, dus invoeren
			$sql = "INSERT INTO `".$tabelnaam."_2_sites` VALUES (NULL , '".$_GET['user_id']."' , '".$_GET['site_id']."')";
			$affected_rows = $db->update_sql($sql);
		}
	
	}
	
	// status teruggeven
	if ($_GET['checked'] == 'true') {
		$melding = 'true';
	} else {
		$melding = 'false';
	}
}


// melding
if ($melding) {
	echo $melding;
}


// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."`, `".$tabelnaam."_2_sites` ";
$affected_rows = $db->update_sql($sql);
?>