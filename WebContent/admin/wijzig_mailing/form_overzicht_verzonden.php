<?php
if (!$_GET['start_pos']) {
	$start = 0;
	$limiet = $limiet_overzicht;
} else {
	$start = ($_GET['start_pos']-1)*$limiet_overzicht;
	$limiet = $limiet_overzicht;
}

// bereken totaal
$sql_totaal = "SELECT * FROM `".$tabelnaam."`WHERE `site_id` = '".$_SESSION['safe_'.$cms_config['token']]['site_id']."' AND `status` = 1";
$result = $db->select($sql_totaal);
$totaal = $db->row_count;

// laat alle items's zien
$sql = $sql_totaal." ORDER BY `datum` DESC LIMIT ".$start.",".$limiet."";
$result = $db->select($sql);
$rows = $db->row_count;


// verwijderen blokkeren
$add_delete = false;

if ($rows >= 1) {
	echo '<h3>Overzicht van verzonden nieuwsbrieven</h3>'."\n";
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item" id="item_'.$pagina_id.'">
			<span class="handler default"> &raquo; </span>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$pagina_id.'&amp;tab=omschrijving&amp;old_tab='.$_GET['tab'].'" class="titel">[<b>'.datum_nl($datum).'</b>] '.inkorten($titel,150).'</a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$pagina_id.',\'verwijder\'); return false;"><img src="img/icons/brief_delete_16.png" alt="verwijderen" /></a>'."\n";

		}
		echo '</li>'."\n";
	}
	echo '</ul>'."\n";
} else {
	echo 'Helaas is er geen '.$item_titel.' gevonden.';  
}

create_nav_get($totaal, $_GET['start_pos'], $limiet_overzicht, '?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;tab='.$_GET['tab'].'', '');
?>