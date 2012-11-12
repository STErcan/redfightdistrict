<?php
// requirements
require_once('../ajax_header.php');


if (isset($_POST['id'])) {
	// update meta in DB
	$descr = sanitize($_POST['descr']);
	
	$sql_update = "UPDATE `files` SET `meta` = '".$descr."' WHERE `file_id` = ".$_POST['id']." LIMIT 1 ";
	$db->update_sql($sql_update);
	echo 'Omschrijving gewijzigd!';
}

?>
