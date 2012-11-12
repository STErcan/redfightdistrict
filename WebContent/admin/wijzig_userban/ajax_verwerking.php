<?php
include('../ajax_header.php');
include('config.php');


// verwijderen
if ($_GET['verwijder'] == 1) {
	// item verwijderen
	$sql = "DELETE FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 1 ";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is verwijderd.';
}


// sites toewijzen
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