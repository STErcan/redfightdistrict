<?php
// laad bijlage plugin
if ($add_bijlagen) {
	$mijn_id = $_GET['id'];
	require_once('plugin_bijlagen/plugin_bijlagen.php');
} else {
	echo 'Deze plugin is niet geactiveerd!';
}
?>
