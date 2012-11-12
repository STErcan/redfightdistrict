<?php
// laad foto plugin
if ($add_foto) {
	$mijn_id = $_GET['id'];
	include('plugin_fotos/plugin_fotos.php');
} else {
	echo 'Deze plugin is niet geactiveerd!';
}
?>
