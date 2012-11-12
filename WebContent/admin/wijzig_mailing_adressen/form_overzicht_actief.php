<?php
if (!$_GET['start_pos']) {
	$start = 0;
	$limiet = $limiet_overzicht;
} else {
	$start = ($_GET['start_pos']-1)*$limiet_overzicht;
	$limiet = $limiet_overzicht;
}

// bereken totaal
$sql_totaal = "SELECT * FROM `".$tabelnaam."`WHERE `status` = 0 ORDER BY `email_adres`";
$result = $db->select($sql_totaal);
$totaal = $db->row_count;

// laat alle items's zien
$sql = $sql_totaal." LIMIT ".$start.",".$limiet."";
$result = $db->select($sql);
$rows = $db->row_count;

if ($rows >= 1) {
	echo '<h3>Actieve abonnees</h3>'."\n";
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item" id="item_'.$email_id.'">
			<span class="handler default"> &raquo; </span>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$email_id.'&amp;tab=omschrijving&amp;old_tab='.$_GET['tab'].'" class="titel">[ '.$email_adres.' ] <b>'.$email_naam.'</b></a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$email_id.',\'verwijder\'); return false;"><img src="img/icons/user_delete_16.png" alt="verwijderen" /></a>'."\n";

		}
		echo '</li>'."\n";
	}
	echo '</ul>'."\n";
} else {
	echo 'Helaas is er geen '.$item_titel.' gevonden.';  
}

create_nav_get($totaal, $_GET['start_pos'], $limiet_overzicht, '?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab='.$_GET['tab'].'', '');
	
// toevoegen van nieuwe items
echo '
<div id="nieuw_item" style="display:none;">
	'.($add_delete ? '<a href="#" onClick="wijzig_item(0,\'omschrijving\');"><img src="img/icons/nieuw_user_32.png" align="absmiddle" /> '.$item_titel.' toevoegen</a>' : '').'
</div>
';
?>