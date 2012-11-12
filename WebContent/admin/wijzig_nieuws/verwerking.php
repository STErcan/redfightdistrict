<?php
// data opschonen
$type = $_POST['type'];
$parent_id = $_POST['parent_id'];
$titel = sanitize($_POST['titel'],true);
$tekst = sanitize($_POST['tekst']);
$tekst_preview = sanitize($_POST['tekst_preview']);
$datum = datum_en($_POST['datum']);
$datum_van = datum_en($_POST['datum_van']);
$datum_tot = datum_en($_POST['datum_tot']);
$meta_url = sanitize(fix_url($_POST['meta_url']));
$meta_url = ($meta_url=='' ? fix_url($titel) : $meta_url);
$meta_descr = sanitize($_POST['meta_descr']);
$meta_key = sanitize($_POST['meta_key']);



// nieuw
if ($_POST['formactie'] == 'nieuw') {

	// nieuwe record in dB
	$sql = "INSERT INTO `".$tabelnaam."` (pagina_id, type, parent_id, titel, tekst, datum, datum_van, datum_tot, meta_url, meta_descr, meta_key, site_id,tekst_preview) ";
	$sql .= "VALUES (NULL, '".$type."', '".$parent_id."', '".$titel."', '".$tekst."', '".$datum."', '".$datum_van."', '".$datum_tot."', '".$meta_url."', '".$meta_descr."', '".$meta_key."', '".$_SESSION['safe_'.$cms_config['token']]['site_id']."','".$tekst_preview."')";
	$mijn_id = $db->insert_sql($sql);
	
	// positie aanpassen (dirrrty)
	$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$mijn_id."' WHERE `pagina_id` = '".$mijn_id."' LIMIT 1";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is toegevoegd.';
	$redirect_url = ''.$base_href.'admin/?pagina='.$module_naam.'&content=item&id='.$mijn_id.'&tab=omschrijving&nieuw';
}



// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	
	// verwerken van omschrijving
	if ($_POST['tab'] == 'omschrijving') {
		$sql = "UPDATE `".$tabelnaam."` SET ";
		$sql .= "`type` = '".$type."', ";
		$sql .= "`parent_id` = '".$parent_id."', ";
		$sql .= "`titel` = '".$titel."', ";
		$sql .= "`tekst` = '".$tekst."', ";
		$sql .= "`datum` = '".$datum."', ";
		$sql .= "`datum_van` = '".$datum_van."', ";
		$sql .= "`datum_tot` = '".$datum_tot."', ";
		$sql .= "`meta_url` = '".$meta_url."', ";
		$sql .= "`meta_descr` = '".$meta_descr."', ";
		$sql .= "`tekst_preview` = '".$tekst_preview."', ";
		$sql .= "`meta_key` = '".$meta_key."' ";
		$sql .= "WHERE `pagina_id` = '".$_POST['id']."' LIMIT 1";
		$affected_rows = $db->update_sql($sql);
		
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
$affected_rows = $db->update_sql($sql);
?>