<?php
// data opschonen
$site_naam = sanitize($_POST['site_naam'],true);


// nieuw
if ($_POST['formactie'] == 'nieuw') {
	$sql = "INSERT INTO `".$tabelnaam."` (site_id, site_naam) ";
	$sql .= "VALUES (NULL, '".$site_naam."')";
	$mijn_id = $db->insert_sql($sql);
	
	// positie aanpassen (dirrrty)
	$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$mijn_id."' WHERE `site_id` = '".$mijn_id."' LIMIT 1";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is toegevoegd.';
}


// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	// verwerken van omschrijving
	if ($_POST['tab'] == 'omschrijving') {
		$sql = "UPDATE `".$tabelnaam."` SET
		`site_naam` = '".$site_naam."'
		WHERE `site_id` = '".$_POST['id']."' LIMIT 1";
		$affected_rows = $db->update_sql($sql);
		
		$melding = $item_pre.' '.$item_titel.' is gewijzigd.';
	}
}


// melding
if ($melding) {
	echo $melding;
	echo redirect($_POST['redirect_url'],2000);
}


// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."` ";
$affected_rows = $db->update_sql($sql);
?>