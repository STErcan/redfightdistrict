<?php
$_GET['tab'] = ($_GET['tab'] ? $_GET['tab'] : $eerste_tab);
// show tabs
echo '
<h3>Overzicht</h3>
<div id="tabs">
	<ul>
		<li id="geblokkeerd"'.($_GET['tab'] == 'geblokkeerd' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=geblokkeerd">Geblokkeerd</a>
		</li>
		<li id="geschiedenis"'.($_GET['tab'] == 'geschiedenis' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=geschiedenis">Geschiedenis</a>
		</li>
	</ul>
</div>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_overzicht_'.$_GET['tab'].'.php');
echo '</div>'."\n";
?>
