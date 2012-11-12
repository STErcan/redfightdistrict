<?php
$_GET['tab'] = ($_GET['tab'] ? $_GET['tab'] : $eerste_tab);


// show tabs
echo '
<h3>Overzicht</h3>
<div id="tabs">
	<ul>
		<li id="overzicht_nieuw"'.($_GET['tab'] == 'overzicht_nieuw' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=overzicht_nieuw">Nieuwe reacties</a>
		</li>
		<li id="overzicht_reacties"'.($_GET['tab'] == 'overzicht_reacties' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=overzicht_reacties">Gemodereerde reacties</a>
		</li>
	</ul>
</div>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_'.$_GET['tab'].'.php');
echo '</div>'."\n";
?>
