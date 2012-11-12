<?php
// laat alle items's zien
$sql = "SELECT * FROM `".$tabelnaam."` WHERE `site_id` = '".$_SESSION['safe_'.$cms_config['token']]['site_id']."' AND `type` = '".$default_type."' AND `status` = 0 ORDER BY `datum` DESC ";
$result = $db->select($sql);
$rows = $db->row_count;

echo '<h4>Nieuwe reacties die nog niet zijn gemodereerd</h4>'."\n";
if ($rows >= 1) {
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item reactie" id="item_'.$reactie_id.'">
			<span class="handler"> &raquo; </span>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$reactie_id.'&amp;tab=omschrijving&amp;old_tab='.$_GET['tab'].'" class="titel">
				<div class="reactie_meta">
					<div class="reactie_datum">'.datum_nl($datum).'</div>
					<!--<div class="reactie_titel">['.inkorten($titel,100).']</div>-->
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
?>