<?php
if (!$_GET['start_pos']) {
	$start = 0;
	$limiet = $limiet_overzicht;
} else {
	$start = ($_GET['start_pos']-1)*$limiet_overzicht;
	$limiet = $limiet_overzicht;
}


// array mailing lijsten
$sql = "SELECT * FROM `mailing_lijsten` ORDER BY `positie`, `lijst_naam`";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		$array_lijsten[$lijst_id] = $lijst_naam;
	}
}

if ($_SESSION['safe_lijst_id']) {
	$mijn_lijst_id = ','.$_SESSION['safe_lijst_id'].',';
} else {
	if (count($array_lijsten)>0) { 
		$array_lijsten_tmp = array_slice($array_lijsten, 0, 1);
		$mijn_lijst_id = ','.$array_lijsten_tmp[0].',';
	} else {
		$mijn_lijst_id = ',,';
	}
}

// bereken totaal
$sql_totaal = "SELECT * FROM `".$tabelnaam."`WHERE `status` = 0 AND `email_lijst` LIKE '%".$mijn_lijst_id."%' ORDER BY `email_adres`";
$result = $db->select($sql_totaal);
$totaal = $db->row_count;

// laat alle items's zien
$sql = $sql_totaal." LIMIT ".$start.",".$limiet."";
$result = $db->select($sql);
$rows = $db->row_count;

echo '
<h3>Actieve abonnees per mailing-lijst</h3>
<div id="sub_menu">
';
if (count($array_lijsten)>0) {
	foreach ($array_lijsten as $key => $waarde) {
		echo '<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab='.$_GET['tab'].'" onClick="set_sessie(\'safe_lijst_id\','.$key.');"'.($_SESSION['safe_lijst_id']==$key ? ' class="actief"' : '').'>'.$waarde.'</a>'."\n";
	}
}
echo '
</div>
';

if ($rows >= 1) {
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
?>