<?php
// requirements
require_once('../ajax_header.php');
require_once('config.php');


// verwerken van omschrijving
if (count($_GET['lijst'])>0) {
	$sql = "UPDATE `".$tabelnaam."` SET `email_lijst` = ',".implode(',',$_GET['lijst']).",' WHERE `".$prefix."id` = '".$_GET['email_id']."' LIMIT 1";
	$affected_rows = $db->update_sql($sql);
} else {
	$sql = "UPDATE `".$tabelnaam."` SET `email_lijst` = '' WHERE `".$prefix."id` = '".$_GET['email_id']."' LIMIT 1";
	$affected_rows = $db->update_sql($sql);
}
?>