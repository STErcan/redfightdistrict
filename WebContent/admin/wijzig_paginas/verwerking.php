<?php
// data opschonen
$type = $_POST['type'];
$parent_id = $_POST['parent_id'];
$titel = sanitize($_POST['titel'],true);
$tekst = sanitize($_POST['tekst']);
$datum = $_POST['datum'];
if ($type == 'events') {
	$datum = datum_en($_POST['datum']);
}
$datum_van = datum_en($_POST['datum_van']);
$datum_tot = datum_en($_POST['datum_tot']);
$meta_url = sanitize(fix_url($_POST['meta_url']));
$meta_url = ($meta_url=='' ? permalink_check($titel, $_POST['id']) : $meta_url);
$meta_descr = sanitize($_POST['meta_descr']);
$meta_key = sanitize($_POST['meta_key']);


// nieuw
if ($_POST['formactie'] == 'nieuw') {

	// nieuwe record in dB
	$sql = "INSERT INTO `".$tabelnaam."` (pagina_id, type, parent_id, titel, tekst, datum, datum_van, datum_tot, meta_url, meta_descr, meta_key, site_id) ";
	$sql .= "VALUES (NULL, '".$type."', '".$parent_id."', '".$titel."', '".$tekst."', '".$datum."', '".$datum_van."', '".$datum_tot."', '".$meta_url."', '".$meta_descr."', '".$meta_key."', '".$_SESSION['safe_'.$cms_config['token']]['site_id']."')";
	$mijn_id = $db->insert_sql($sql);
	
	// insert extra data velden
	if (count($array_datavelden_types[$_POST['type']])>0) {
		foreach ($array_datavelden_types[$_POST['type']] as $key => $waarde) {
			$sql = "INSERT INTO `".$tabelnaam."_data` (data_id, type, waarde, parent_id) ";
			$sql .= "VALUES (NULL, '".$waarde."', '".sanitize($_POST[$waarde],true)."', '".$mijn_id."')";
			$data_id = $db->insert_sql($sql);
		}
	}

	// positie aanpassen (dirrrty)
	$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$mijn_id."' WHERE `pagina_id` = '".$mijn_id."' LIMIT 1";
	$db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is toegevoegd.';
	$redirect_url = ''.$base_href.'admin/?pagina='.$module_naam.'&type='.$type.'&content=item&id='.$mijn_id.'&tab='.$eerste_tab.'&nieuw';
}



// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	
	// verwerken van omschrijving
	if ($_POST['tab'] == $form_omschrijving_types[$_POST['type']]) {
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
		$sql .= "`meta_key` = '".$meta_key."' ";
		$sql .= "WHERE `pagina_id` = '".$_POST['id']."' LIMIT 1";
		$db->update_sql($sql);
		
		// insert extra data velden
		if (count($array_datavelden_types[$_POST['type']])>0) {
			foreach ($array_datavelden_types[$_POST['type']] as $key => $waarde) {
				
				$sql_check = "SELECT * FROM `".$tabelnaam."_data` WHERE `type` = '".$waarde."' AND `parent_id` = '".$_POST['id']."' LIMIT 0,1 ";
				$result_check = $db->select($sql_check);
				$rows_check = $db->row_count;
				
				// updaten
				if ($rows_check == 1)  {
					$sql = "UPDATE `".$tabelnaam."_data` SET `waarde` = '".sanitize($_POST[$waarde])."' ";
					$sql .= "WHERE `type` = '".$waarde."' AND `parent_id` = '".$_POST['id']."'";
					$db->update_sql($sql);
				
				// toevoegen
				} else {					
					$sql = "INSERT INTO `".$tabelnaam."_data` (data_id, type, waarde, parent_id) ";
					$sql .= "VALUES (NULL, '".$waarde."','".sanitize($_POST[$waarde])."','".$_POST['id']."')";
					$insert_id = $db->insert_sql($sql);
				}
			}
		}
		
		$melding = $item_pre.' '.$item_titel.' is gewijzigd.';
	}
}



// melding
if ($melding) {
	echo $melding;
	echo redirect(($redirect_url ? $redirect_url : $_POST['redirect_url']),1000);
}



// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."`,`".$tabelnaam."_data` ";
$db->update_sql($sql);
?>