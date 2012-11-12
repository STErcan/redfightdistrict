<?php
include('../ajax_header.php');
include('config.php');

// posities verwerken
if ($_GET['positie'] == 1) {
	// array uitlezen
	if (count($_GET['item'])>1) {
		foreach ($_GET['item'] as $key => $waarde) {
			$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$key."' WHERE `lijst_id` = '".$waarde."' LIMIT 1";
			$affected_rows = $db->update_sql($sql);
		}
	}
	$melding = 'Posities zijn gewijzigd.';
}


// verwijderen
if ($_GET['verwijder'] == 1) {
	// item verwijderen
	$sql = "DELETE FROM `".$tabelnaam."` WHERE `lijst_id` = '".$_GET['id']."' LIMIT 1 ";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is verwijderd.';
}
?>