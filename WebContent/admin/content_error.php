<?php
if (!$_SESSION['safe_'.$cms_config['token']]['site_id']) {
	echo '
	<h1>Fout!</h1>
	<p>U heeft niet de juiste rechten om paginas te bekijken. Dit komt omdat uw user-account geen -sites- toegewezen heeft gekregen. Neem hiervoor contact op met de hoofdgebruiker: <a href="mailto:'.$cms['contact'].'">'.$cms['contact'].'</a>.</p>	
	';
} else {
	echo '
	<h1>Fout!</h1>
	<p>De door u opgevraagde pagina bestaat niet, of u heeft niet de juiste rechten om deze pagina te bekijken.</p>	
	';
}
?>
