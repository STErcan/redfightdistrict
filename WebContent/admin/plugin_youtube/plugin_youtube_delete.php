<?php
// requirements
require_once('../ajax_header.php');

if (isset($_GET['id'])) {
	$mijn_id = str_replace('x_', '', $_GET['id']);

	// delete in DB
	$sql_delete = "DELETE FROM `files` WHERE `file_id` = '".$mijn_id."' LIMIT 1 ";
	$db->update_sql($sql_delete);

	// reactie
	echo 'Video <em>'.$naam.'</em> verwijderd';

} else {
	echo 'item geselecteerd';
}

?>
