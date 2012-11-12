<?php
// data opschonen
$type = $_POST['type'];
$parent_id = $_POST['parent_id'];
$titel = sanitize($_POST['titel'],true);
$tekst = sanitize($_POST['tekst']);
$datum = datum_en($_POST['datum']);
$auteur_naam = sanitize($_POST['auteur_naam'],true);
$auteur_email = sanitize($_POST['auteur_email']);
$status = $_POST['status'];



// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	
	// verwerken van omschrijving
	if ($_POST['tab'] == 'omschrijving') {
		$sql = "UPDATE `".$tabelnaam."` SET
		`type` = '".$type."',
		`parent_id` = '".$parent_id."',
		`titel` = '".$titel."',
		`tekst` = '".$tekst."',
		`auteur_naam` = '".$auteur_naam."',
		`auteur_email` = '".$auteur_email."',
		`status` = '".$status."'
		WHERE `reactie_id` = '".$_POST['id']."' LIMIT 1";
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