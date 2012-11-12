<?php
if (!$_GET['start_pos']) {
	$start = 0;
	$limiet = $limiet_overzicht;
} else {
	$start = ($_GET['start_pos']-1)*$limiet_overzicht;
	$limiet = $limiet_overzicht;
}
$vandaag = date('Y-m-d');
// bereken totaal
$sql_totaal = "SELECT * FROM `".$tabelnaam."`WHERE `type` = 'nieuws' AND `site_id` = '".$_SESSION['safe_'.$cms_config['token']]['site_id']."'";
$result = $db->select($sql_totaal);
$totaal = $db->row_count;

// laat alle items zien
$sql = $sql_totaal." ORDER BY `datum` DESC, `pagina_id` DESC LIMIT ".$start.",".$limiet."";
$result = $db->select($sql);
$rows = $db->row_count;

if ($rows >= 1) {
	echo '<h3>Overzicht</h3>'."\n";
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		if ($zichtbaarheid) {
			$outdated = (($datum_van>$vandaag || $datum_tot<$vandaag) ? ' outdated' : '');
		}
		echo '
		  <li class="item'.$outdated.'" id="item_'.$pagina_id.'">
			<span class="handler default"> &raquo; </span>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$pagina_id.'" class="titel">[<b>'.datum_nl($datum).'</b>] '.$titel.'</a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$pagina_id.',\'verwijder\'); return false;"><img src="img/icons/pagina_delete_16.png" alt="verwijderen" /></a>'."\n";
		}
		echo '</li>'."\n";
	}
	echo '</ul>'."\n";
} else {
	echo 'Helaas is er geen '.$item_titel.' gevonden.';  
}

// navigatie
create_nav_get($totaal, $_GET['start_pos'], $limiet_overzicht, '?pagina='.$_GET['pagina'].'&amp;type=&amp;content=overzicht&amp;tab='.$_GET['tab'].'', '');

// toevoegen van nieuwe items
echo '
<div id="nieuw_item">
	'.($add_delete ? '<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id=0"><img src="img/icons/nieuw_pagina_32.png" align="absmiddle" /> '.$item_titel.' toevoegen</a>' : '').'
</div>
';
?>