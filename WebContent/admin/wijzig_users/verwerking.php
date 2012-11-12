<?php
// data opschonen
$user_login = sanitize($_POST['user_login']);
$user_pass = sanitize($_POST['user_pass']);
$user_priv = sanitize($_POST['user_priv']);
$user_opm = sanitize($_POST['user_opm']);
$user_naam = sanitize($_POST['user_naam'],true);
$user_email = sanitize($_POST['user_email']);



// nieuw
if ($_POST['formactie'] == 'nieuw') {

	$sql = "INSERT INTO `".$tabelnaam."` (user_id, user_login, user_pass, user_priv, user_opm, user_naam, user_email) ";
	$sql .= "VALUES (NULL, '".$user_login."', '".rand(0,1979)."', '".$user_priv."', '".$user_opm."', '".$user_naam."', '".$user_email."')";
	$mijn_id = $db->insert_sql($sql);
	
	// wachtwoord aanpassen
	$user_pass = sha1($user_pass.'+'.$mijn_id);
	$sql = "UPDATE `".$tabelnaam."` SET `user_pass` = '".$user_pass."' WHERE `".$prefix."id` = '".$mijn_id."' LIMIT 1";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is toegevoegd.';
}



// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	
	// verwerken van omschrijving
	if ($_POST['tab'] == 'omschrijving') {
		$sql = "UPDATE `".$tabelnaam."` SET ";
		$sql .= "`user_login` = '".$user_login."', ";
		$sql .= "`user_priv` = '".$user_priv."', ";
		$sql .= "`user_opm` = '".$user_opm."', ";
		$sql .= "`user_naam` = '".$user_naam."', ";
		$sql .= "`user_email` = '".$user_email."' ";
		$sql .= "WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
		$affected_rows = $db->update_sql($sql);
		
		// wachtwoord aanpassen
		if ($_POST['user_pass'] != '') {
			$user_pass = sha1($user_pass.'+'.$_POST['id']);
			$sql = "UPDATE `".$tabelnaam."` SET ";
			$sql .= "`user_pass` = '".$user_pass."' ";
			$sql .= "WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
			$affected_rows = $db->update_sql($sql);
		}
		
		$melding = $item_pre.' '.$item_titel.' is gewijzigd.';
	}
}




// melding
if ($melding) {
	echo $melding;
	echo redirect($_POST['redirect_url']);
}



// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."` ";
$db->update_sql($sql);
?>