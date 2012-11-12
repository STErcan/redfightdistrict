<?php
echo '<h1>Content Management Systeem voor '.$cms_config['bedrijf_naam'].'</h1>'."\n";
if ($_GET['site_id']) {
	
	if ($_SESSION['safe_'.$cms_config['token']]['site_id'] == $_GET['site_id']) {
		echo '
		<div id="melding"><b>Let op:</b> U bent zojuist van website gewisseld naar: <b>'.$array_websites[$_GET['site_id']].'</b></div><br />';
	} else {
		echo '
		<div id="melding"><b>Let op:</b> U heeft <u>geen rechten</u> om de website <b>'.$array_websites[$_GET['site_id']].'</b> te wijzigen!</div><br />';
	}
} else if (!$_SESSION['safe_'.$cms_config['token']]['site_id']) {
		echo '
		<div id="melding"><b>Let op:</b> U heeft <u>geen rechten</u> om websites te wijzigen!</div><br />';
} else {
	echo '
	<p>Voor vragen en opmerkingen kunt u<br />
	contact op nemen met <a href="mailto:'.$cms['contact'].'">'.$cms['contact'].'</a></p>
	<br />
	';
}
?>

