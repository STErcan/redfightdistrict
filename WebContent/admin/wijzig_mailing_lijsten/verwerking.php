<?php
// data opschonen
$lijst_naam = sanitize($_POST['lijst_naam']);
$status = $_POST['status'];


// nieuw
if ($_POST['formactie'] == 'nieuw') {

	$sql = "INSERT INTO `".$tabelnaam."` (lijst_id, lijst_naam, status) ";
	$sql .= "VALUES (NULL, '".$lijst_naam."', '".$status."')";
	$mijn_id = $db->insert_sql($sql);
	
	$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$mijn_id."' WHERE `lijst_id` = '".$mijn_id."' LIMIT 1";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is toegevoegd.';
}


// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	
	// verwerken van omschrijving
	if ($_POST['tab'] == 'omschrijving') {
		$sql = "UPDATE `".$tabelnaam."` SET ";
		$sql .= "`lijst_naam` = '".$lijst_naam."', ";
		$sql .= "`status` = '".$status."' ";
		$sql .= "WHERE `lijst_id` = '".$_POST['id']."' LIMIT 1";
		$affected_rows = $db->update_sql($sql);
		
		$melding = $item_pre.' '.$item_titel.' is gewijzigd.';
	}
}


// melding
if ($melding) {
	echo $melding;
	echo redirect($_POST['redirect_url'],1500);
}


// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."` ";
$affected_rows = $db->update_sql($sql);
?>