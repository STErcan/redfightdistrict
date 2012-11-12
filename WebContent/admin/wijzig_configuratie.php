<?php 
// requirements
require_once('wijzig_configuratie/config.php');

## -- privileges
if ($privileges) {

	## -- titel
	echo '<h1>'.$pagina_main_titel.'</h1>'."\n";
	
	## -- melding divs
	echo '<div id="opmerking" style="display:none;"></div>'."\n";
	echo '<div id="wijzig" style="display:none; padding:1px;"></div>'."\n";
	

	// include het juiste formulier
	if ($_GET['content']) {
		require_once('wijzig_'.$module_naam.'/'.$_GET['content'].'.php');
	}

## -- privilege error
} else {
	require_once('content_priv_error.php');
}
?>