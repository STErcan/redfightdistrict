<?php
// requirements
require_once('../ajax_header.php');
require_once('config.php');



// verwijderen
if ($_GET['verwijder'] == 1) {
	// item verwijderen
	$sql = "DELETE FROM `".$tabelnaam."` WHERE `reactie_id` = '".$_GET['id']."' LIMIT 1 ";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is verwijderd.';
}



// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."` ";
$affected_rows = $db->update_sql($sql);
?>