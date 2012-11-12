<?php
// laat alle items zien
$bericht = "Helaas is er geen ".$item_titel." gevonden.";  

$sql = "SELECT * FROM `".$tabelnaam."` ORDER BY `user_priv`,`user_login` ";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	echo '<h3>Overzicht</h3>'."\n";
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item" id="item_'.$user_id.'">
			<span class="handler default"> &raquo; </span>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$user_id.'" class="titel">[<b>'.$priv_array[$user_priv].'</b>] '.$user_naam.'</a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$user_id.',\'verwijder\'); return false;"><img src="img/icons/user_delete_16.png" alt="verwijderen" /></a>'."\n";
		}
		echo '</li>'."\n";
	}
	echo '</ul>'."\n";
} else {
	echo $bericht;
}

// toevoegen van nieuwe items
echo '
<div id="nieuw_item">
	'.($add_delete ? '<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id=0"><img src="img/icons/nieuw_user_32.png" align="absmiddle" /> '.$item_titel.' toevoegen</a>' : '').'
</div>
';
?>