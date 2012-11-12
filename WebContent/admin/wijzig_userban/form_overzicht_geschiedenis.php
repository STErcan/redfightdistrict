<?php
// overzicht geschiedenis ip-adressen
$bericht = "Er is geen ".$item_titel." gevonden.";  

$sql = "SELECT * FROM `".$tabelnaam."` WHERE `blokkeer` = '0' ORDER BY `timestamp` DESC LIMIT 0,50";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	echo '<h4>Opgeheven blokkeringen</h4>'."\n";
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item" id="item_'.$id.'">
			<span class="handler default"> &raquo; </span>
			<a href="#" class="titel clean" onClick="return false;">[<b>'.$ip_adres.'</b>] '.datum_nl($timestamp).'</a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$id.',\'verwijder\'); return false;"><img src="img/icons/delete_16.png" alt="Deblokkeer" title="Verwijder" /></a>'."\n";
		}
		echo '</li>'."\n";
	}
	echo '</ul>'."\n";
} else {
	echo $bericht;
}
?>