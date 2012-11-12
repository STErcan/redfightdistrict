<?php
// laat alle items's zien
$sql = "SELECT * FROM `".$tabelnaam."`WHERE `site_id` = '".$_SESSION['safe_'.$cms_config['token']]['site_id']."' AND `status` = 0 ORDER BY `datum` DESC ";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	echo '<h3>Te verzenden nieuwsbrieven</h3>'."\n";
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item" id="item_'.$pagina_id.'">
			<span class="handler default"> &raquo; </span>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$pagina_id.'&amp;tab=omschrijving&amp;old_tab='.$_GET['tab'].'" class="titel">[<b>'.datum_nl($datum).'</b>] '.inkorten($titel,150).'</a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$pagina_id.',\'verwijder\'); return false;"><img src="img/icons/mail_close_16.png" alt="verwijderen" /></a>'."\n";
		}
		echo '</li>'."\n";
	}
	echo '</ul>'."\n";
} else {
	echo 'Helaas is er geen '.$item_titel.' gevonden.';
}

// toevoegen van nieuwe items
echo '
<div id="nieuw_item">
	'.($add_delete ? '<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id=0&amp;tab=omschrijving"><img src="img/icons/nieuw_brief_32.png" align="absmiddle" /> '.$item_titel.' toevoegen</a>' : '').'
</div>
';
?>