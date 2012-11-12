<?php
// controleer mailing-status
$sql = "SELECT `status` AS `mailing_verzonden` FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1)  {
		extract($db->get_row($result));
}

// navigatie
echo '
<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=overzicht&amp;tab='.$_GET['old_tab'].'" id="sublink">&laquo; terug naar het overzicht</a>
<h3>'.($_GET['id']==0 ? $item_titel.' toevoegen' : ($mailing_verzonden!=1 ? $item_titel.' wijzigen' : 'Verzonden '.$item_titel.' bekijken')).'</h3>
';


// melding nieuw item
if (isset($_GET['nieuw'])) {
	echo '
	<div id="melding"><b>Let op:</b> U heeft zojuist een '.$item_pre_nieuw.' '.$item_titel.' aangemaakt. 
	Gebruik de nieuwe tabs om '.$item_pre.' '.$item_titel.' van extra informatie te voorzien.</div>
	';
}


echo '
<div id="tabs">
	<ul>
		<li id="omschrijving"'.($_GET['tab'] == 'omschrijving' ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=omschrijving'.($_GET['old_tab'] ? '&amp;old_tab='.$_GET['old_tab'] : '').'">Omschrijving</a>
		</li>
		'.($_GET['id']>0 ? '
			<!--<li id="items"'.($_GET['tab'] == 'items' ? ' class="active"' : '').'>
				<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=items'.($_GET['old_tab'] ? '&amp;old_tab='.$_GET['old_tab'] : '').'">Extra Inhoud</a>
			</li>-->
			'.($mailing_verzonden!=1 ? '
				<li id="versturen_test"'.($_GET['tab'] == 'versturen_test' ? ' class="active"' : '').'>
					<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=versturen_test">Versturen test</a>
				</li>
				<li id="versturen_def"'.($_GET['tab'] == 'versturen_def' ? ' class="active"' : '').'>
					<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=versturen_def">Versturen definitief</a>
				</li>
			' : '' ).'
		' : '' ).'
	</ul>
</div>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_'.$_GET['tab'].'.php');
echo '</div>'."\n";
?>
