<?php
// requirements
require_once('../ajax_header.php');
require_once('config.php');

if ($_GET['email_naam'] != '' && $_GET['email_adres'] != '') {
	$sql_where = "`email_naam` LIKE '%".$_GET['email_naam']."%' AND `email_adres` LIKE '%".$_GET['email_adres']."%'";
} else if ($_GET['email_naam'] != '') {
	$sql_where = "`email_naam` LIKE '%".$_GET['email_naam']."%'";
} else if ($_GET['email_adres'] != '') {
	$sql_where = "`email_adres` LIKE '%".$_GET['email_adres']."%'";
} else {
	exit();
}

// bereken totaal
$sql = "SELECT * FROM `".$tabelnaam."` WHERE ".$sql_where." ORDER BY `email_adres` LIMIT 0,10";
$result = $db->select($sql);
$rows = $db->row_count;

if ($rows >= 1) {
	echo '<h4>Gevonden abonnees</h4>'."\n";
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
?>