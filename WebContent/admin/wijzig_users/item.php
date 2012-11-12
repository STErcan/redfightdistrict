<?php
// show menu
echo '
<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht" id="sublink">&laquo; terug naar het overzicht</a>
<h3>'.$item_titel.' '.($_GET['id']>0 ? 'wijzigen' : 'toevoegen').'</h3>
';


// show tabs
$_GET['tab'] = ($_GET['tab'] ? $_GET['tab'] : $eerste_tab);
echo '
<div id="tabs">
	<ul>
		<li id="omschrijving"'.($_GET['tab'] == 'omschrijving' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=omschrijving">Omschrijving</a>
		</li>
		'.($_GET['id']>0 ? '
			'.($add_foto ? '
			<li id="fotos"'.($_GET['tab'] == 'fotos' ? ' class="active"' : '').'>
				<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=fotos">Pagina Foto\'s</a>
			</li>
			' : '' ).'
	
			'.($add_galerij ? '
			<li id="galerij"'.($_GET['tab'] == 'galerij' ? ' class="active"' : '').'>
				<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=galerij">Galerij</a>
			</li>
			' : '' ).'
			
			'.($add_bijlagen ? '
			<li id="bijlagen">
				<a href="?pagina='.$_GET['pagina'].'&amp;content=bijlagen&amp;id='.$_GET['id'].'&amp;tab=bijlagen">Bijlagen</a>
			</li>
			' : '' ).'
		<li id="sites"'.($_GET['tab'] == 'sites' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=sites">Sites</a>
		</li>
		' : '' ).'
	</ul>
</div>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_'.$_GET['tab'].'.php');
echo '</div>'."\n";
?>
