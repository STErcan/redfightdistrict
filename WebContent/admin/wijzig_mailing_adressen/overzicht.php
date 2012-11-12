<?php
$_GET['tab'] = ($_GET['tab'] ? $_GET['tab'] : $eerste_tab);
// show tabs
echo '
<div id="tabs">
	<ul>
		<li id="overzicht_zoeken"'.($_GET['tab'] == 'overzicht_zoeken' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=overzicht_zoeken">Zoeken</a>
		</li>
		<li id="overzicht_actief"'.($_GET['tab'] == 'overzicht_actief' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=overzicht_actief">Actief</a>
		</li>
		<li id="overzicht_geblokkeerd"'.($_GET['tab'] == 'overzicht_geblokkeerd' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=overzicht_geblokkeerd">Geblokkeerd</a>
		</li>
		<li id="overzicht_per_lijst"'.($_GET['tab'] == 'overzicht_per_lijst' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab=overzicht_per_lijst">Per mailing-lijst</a>
		</li>
<!--		<li id="overzicht_toevoegen"'.($_GET['tab'] == 'overzicht_toevoegen' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id=0&amp;tab=omschrijving&amp;old_tab=overzicht_toevoegen">Abonee toevoegen</a>
		</li>-->
	</ul>
</div>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_'.$_GET['tab'].'.php');
echo '</div>'."\n";
?>
