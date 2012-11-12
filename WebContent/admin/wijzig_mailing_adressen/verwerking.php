<?php
// data opschonen
$email_id = $_POST['email_id'];
$email_adres = sanitize($_POST['email_adres']);
$email_naam = sanitize($_POST['email_naam']);
$email_type = $_POST['email_type'];
$status = $_POST['status'];


// nieuw
if ($_POST['formactie'] == 'nieuw') {

	// nieuwe record in dB
	$sql = "INSERT INTO `".$tabelnaam."` (email_id, email_adres, email_naam, email_type, status) ";
	$sql .= "VALUES (NULL, '".$email_adres."', '".$email_naam."', '".$email_type."', '".$status."')";
	$mijn_id = $db->insert_sql($sql);
	
	$redirect_url = '?pagina=mailing_adressen&content=item&id='.$mijn_id.'&tab=lijst';
	$melding = $item_pre.' '.$item_titel.' is toegevoegd.';
}



// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	
	// verwerken van omschrijving
	if ($_POST['tab'] == 'omschrijving') {
		$sql = "UPDATE `".$tabelnaam."` SET ";
		$sql .= "`email_adres` = '".$email_adres."', ";
		$sql .= "`email_naam` = '".$email_naam."', ";
		$sql .= "`email_type` = '".$email_type."', ";
		$sql .= "`status` = '".$status."' ";
		$sql .= "WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
		$affected_rows = $db->update_sql($sql);
		
		$redirect_url = $_POST['redirect_url'];
		$melding = $item_pre.' '.$item_titel.' is gewijzigd.';
	}
}



// melding
if ($melding) {
	echo $melding;	
	echo redirect($redirect_url,1500);
}



// tabel opschonen
$sql = "OPTIMIZE TABLE `files`, `".$tabelnaam."` ";
$affected_rows = $db->update_sql($sql);
?>