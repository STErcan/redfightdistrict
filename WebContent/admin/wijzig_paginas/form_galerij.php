<?php
// laad galerij plugin
if ($add_galerij) {
	$mijn_id = $_GET['id'];
	require_once('plugin_galerij/plugin_galerij.php');
} else {
	echo 'Deze plugin is niet geactiveerd!';
}
?>
