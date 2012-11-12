<?php
// requirements
require_once('../ajax_header.php');


// posities verwerken
if ($_GET['positie'] == 1) {
	// array uitlezen
	
	if (count($_GET['x'])>1) {
		foreach ($_GET['x'] as $key => $waarde) {
			$sql = "UPDATE `files` SET `pos` = '".$key."' WHERE `file_id` = '".$waarde."' LIMIT 1";
			$db->update_sql($sql);
		}
	}
	echo $melding = 'Posities zijn gewijzigd.';
}
?>