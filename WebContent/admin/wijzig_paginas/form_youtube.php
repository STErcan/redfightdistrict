<?php
// laad bijlage plugin
if ($add_youtube) {
	$mijn_id = $_GET['id'];
	require_once('plugin_youtube/plugin_youtube.php');
} else {
	echo 'Deze plugin is niet geactiveerd!';
}
?>
