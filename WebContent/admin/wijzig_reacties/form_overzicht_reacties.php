<?php
if (!$_GET['start_pos']) {
	$start = 0;
	$limiet = $limiet_overzicht;
} else {
	$start = ($_GET['start_pos']-1)*$limiet_overzicht;
	$limiet = $limiet_overzicht;
}

// bereken totaal
$sql_totaal = "SELECT * FROM `".$tabelnaam."`WHERE `site_id` = '".$_SESSION['safe_'.$cms_config['token']]['site_id']."' AND `type` = '".$default_type."' AND `status` = 1";
$result = $db->select($sql_totaal);
$totaal = $db->row_count;

// laat alle items's zien
$sql = $sql_totaal." ORDER BY `datum` DESC, `reactie_id` DESC LIMIT ".$start.",".$limiet."";
$result = $db->select($sql);
$rows = $db->row_count;
echo '<h4>Overzicht van zichtbare reacties</h4>'."\n";
if ($rows >= 1) {
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item reactie" id="item_'.$reactie_id.'">
			<span class="handler"> &raquo; </span>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$reactie_id.'&amp;tab=omschrijving&amp;old_tab='.$_GET['tab'].'" class="titel">
				<div class="reactie_meta">
					<div class="reactie_titel">['.datum_nl($datum).']</div>
					<div class="reactie_auteur">'.$auteur_naam.'</div>
					<div class="clear"></div>
					<div class="reactie_descr">'.inkorten($tekst,200).'</div>
				</div>
			</a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$reactie_id.',\'verwijder\'); return false;"><img src="img/icons/reactie_delete_16.png" alt="verwijderen" /></a>'."\n";

		}
		echo '</li>'."\n";
	}
	echo '</ul>'."\n";
} else {
	echo 'Er zijn geen nieuwe '.$item_titel_mv.' gevonden.';
}

create_nav_get($totaal, $_GET['start_pos'], $limiet_overzicht, '?pagina='.$_GET['pagina'].'&amp;type=&amp;content=overzicht&amp;tab='.$_GET['tab'].'', '');
?>