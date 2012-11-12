<?php
$_GET['tab'] = ($_GET['tab'] ? $_GET['tab'] : $eerste_tab);


// tabs
echo '
<div id="tabs">
	<ul>
		<li id="overzicht_nieuw"'.($_GET['tab'] == 'overzicht_nieuw' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=overzicht_nieuw">Nieuw</a>
		</li>
		<li id="overzicht_verzonden"'.($_GET['tab'] == 'overzicht_verzonden' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=overzicht_verzonden">Verzonden</a>
		</li>
	</ul>
</div>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_'.$_GET['tab'].'.php');
echo '</div>'."\n";
?>