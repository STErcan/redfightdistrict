<?php
// data opschonen
$config_item = sanitize(fix_url($_POST['config_item']));
$config_omschrijving = sanitize($_POST['config_omschrijving']);

// nieuw
if ($_POST['formactie'] == 'nieuw') {
	$sql = "INSERT INTO `".$tabelnaam."` (config_id, config_item, config_omschrijving) ";
	$sql .= "VALUES (NULL, '".$config_item."', '".$config_omschrijving."')";
	$mijn_id = $db->insert_sql($sql);
	
	// positie aanpassen (dirrrty)
	$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$mijn_id."' WHERE `config_id` = '".$mijn_id."' LIMIT 1";
	$db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is toegevoegd.';
}


// wijzigen
if ($_POST['formactie'] == 'wijzig') {
	
	// verwerken van omschrijving
	if ($_POST['tab'] == 'omschrijving') {
		$sql = "UPDATE `".$tabelnaam."` SET ";
		$sql .= "`config_item` = '".$config_item."', ";
		$sql .= "`config_omschrijving` = '".$config_omschrijving."' ";
		$sql .= "WHERE `".$prefix."id` = '".$_POST['id']."' LIMIT 1";
		$db->update_sql($sql);
		
		$melding = ''.$item_pre.' '.$item_titel.' is gewijzigd.';
	}
} 
 

// specifiek update extra config bestand
$sql = "SELECT * FROM `".$tabelnaam."` ORDER BY `positie` ";	
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	
	// selecteer bestand om te schrijven
	$bestand = '../includes/config.inc.extra.php';
	$fh = fopen($bestand, 'w') or die('Kan bestand niet openen, check permissies!');
	$data = '<?php'."\n";
	
	for ($i=1; $i<=$rows; $i++) {
		$config_array = $db->get_row($result);
		$data .= '$cms_config[\''.$config_array['config_item'].'\'] = \''.$config_array['config_omschrijving'].'\'; '."\n";
	}
	
	$data .= '?>';
	fwrite($fh, $data);
	fclose($fh);
	$melding .= '<br />&raquo; het configbestand is geupdate.';
}


// melding
if ($melding) {
	echo $melding;
	echo redirect($_POST['redirect_url'],2000);
}


// tabel opschonen
$sql = "OPTIMIZE TABLE `".$tabelnaam."` ";
$db->update_sql($sql);
?>