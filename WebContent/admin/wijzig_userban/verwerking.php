<?php
// requirements
require_once('../ajax_header.php');
require_once('config.php');


// deblokkeren
if ($_GET['deblokkeer'] == 1) {
	
	// verwerken van omschrijving
	$sql = "UPDATE `".$tabelnaam."` SET
	`blokkeer` = '0'
	WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 1";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is opgeheven.';
}


// melding
if ($melding) {
	echo $melding;
}


// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."` ";
$affected_rows = $db->update_sql($sql);
?>