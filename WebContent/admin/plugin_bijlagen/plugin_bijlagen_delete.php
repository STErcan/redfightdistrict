<?php
// requirements
require_once('../ajax_header.php');



if (isset($_GET['id'])) {
	$mijn_id = str_replace('x_', '', $_GET['id']);
	
	// verwijder file
	$sql = "SELECT * FROM `files` WHERE `file_id` = ".$mijn_id." LIMIT 0,1 ";
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows == 1) {
		extract($db->get_row($result));
		@unlink("../../".$dir.$naam);
	}

	// delete in DB
	$sql_delete = "DELETE FROM `files` WHERE `file_id` = ".$mijn_id." LIMIT 1 ";
	$db->update_sql($sql_delete);

	// reactie
	echo 'Bestand <em>'.$naam.'</em> verwijderd';

} else {
	echo 'item geselecteerd';
}

?>
