<?php
// menu
echo '
<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=overzicht'.($_GET['old_tab'] ? '&amp;tab='.$_GET['old_tab'] : '').'" id="sublink">&laquo; terug naar het overzicht</a>
<h3>'.$item_titel.' '.($_GET['id']>0 ? 'wijzigen' : 'toevoegen').'</h3>
';


// tabs
echo '
<div id="tabs">
	<ul>
		<li id="omschrijving"'.($_GET['tab'] == 'omschrijving' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=omschrijving">Omschrijving</a>
		</li>
	</ul>
</div>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_'.$_GET['tab'].'.php');
echo '</div>'."\n";
?>