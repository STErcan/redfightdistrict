<?php
// data opschonen
$type = $_POST['type'];
$parent_id = $_POST['parent_id'];
$titel = sanitize($_POST['titel']);
$tekst_html = sanitize($_POST['tekst_html']);
$tekst_txt = sanitize($_POST['tekst_txt']);
$datum = ($_POST['datum']);
$template = $_POST['template'];
$afzender_naam = sanitize($_POST['afzender_naam']);
$afzender_email = sanitize($_POST['afzender_email']);
$status = $_POST['status'];



// lijsten ophalen :
foreach ($_POST as $key => $value) {
	if(substr($key,0,6) == 'lijst_'){
		$arraylijsten[] = $value;
	}
}



// nieuw
if ($_POST['formactie'] == 'nieuw') {

	// nieuwe record in dB
	$sql = "INSERT INTO `".$tabelnaam."` (pagina_id, type, parent_id, titel, tekst_html, tekst_txt, datum, template, status, afzender_naam, afzender_email, site_id) ";
	$sql .= "VALUES (NULL, '".$type."', '".$parent_id."', '".$titel."', '".$tekst_html."', '".$tekst_txt."', '".$datum."', '".$template."', '0', '".$afzender_naam."', '".$afzender_email."', '".$_SESSION['safe_'.$cms_config['token']]['site_id']."')";
	$mijn_id = $db->insert_sql($sql);
	
	// verwerken van mailing lijsten
	if (count($arraylijsten)>0) {
		$sql = "UPDATE `".$tabelnaam."` SET `email_lijst` = ',".implode(',',$arraylijsten).",' WHERE `".$prefix."id` = '".$mijn_id."' LIMIT 1";
		$affected_rows = $db->update_sql($sql);
	} else {
		$sql = "UPDATE `".$tabelnaam."` SET `email_lijst` = '' WHERE `".$prefix."id` = '".$mijn_id."' LIMIT 1";
		$affected_rows = $db->update_sql($sql);
	}
	
	$melding = $item_pre.' '.$item_titel.' is toegevoegd.';
	$redirect_url = ''.$base_href.'admin/?pagina='.$module_naam.'&content=item&id='.$mijn_id.'&tab=omschrijving&nieuw';
}



// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	
	// verwerken van omschrijving
	if ($_POST['tab'] == 'omschrijving') {
		$sql = "UPDATE `".$tabelnaam."` SET ";
		$sql .= "`parent_id` = '".$parent_id."', ";
		$sql .= "`titel` = '".$titel."', ";
		$sql .= "`tekst_html` = '".$tekst_html."', ";
		$sql .= "`tekst_txt` = '".$tekst_txt."', ";
		$sql .= "`datum` = '".$datum."', ";
		$sql .= "`template` = '".$template."', ";
		$sql .= "`status` = '".$status."', ";
		$sql .= "`afzender_naam` = '".$afzender_naam."', ";
		$sql .= "`afzender_email` = '".$afzender_email."' ";
		$sql .= "WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
		$db->update_sql($sql);
		
		
		// verwerken van mailing lijsten
		if (count($arraylijsten)>0) {
			$sql = "UPDATE `".$tabelnaam."` SET `email_lijst` = ',".implode(',',$arraylijsten).",' WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
			$db->update_sql($sql);
		} else {
			$sql = "UPDATE `".$tabelnaam."` SET `email_lijst` = '' WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
			$db->update_sql($sql);
		}
		$melding = $item_pre.' '.$item_titel.' is gewijzigd.';
		$redirect_url = ''.$base_href.'admin/?pagina='.$module_naam.'&content=item&id='.$_POST['id'].'&tab=omschrijving';
	}
	
	
	// verwerken van omschrijving
	if ($_POST['tab'] == 'items') {
		// verwerken van mailing lijsten
		if (count($arraylijsten)>0) {
			$sql = "UPDATE `".$tabelnaam."` SET `items` = ',".implode(',',$arraylijsten).",' WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
			$db->update_sql($sql);
		} else {
			$sql = "UPDATE `".$tabelnaam."` SET `items` = '' WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
			$db->update_sql($sql);
		}
		
		$melding = $item_pre.' '.$item_titel.' is gewijzigd.';
	}
}



// melding
if ($melding) {
	echo $melding;
	echo redirect(($redirect_url ? $redirect_url : $_POST['redirect_url']),1500);
}



// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."` ";
$db->update_sql($sql);
?>