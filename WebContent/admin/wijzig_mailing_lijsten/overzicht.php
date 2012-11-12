<?php
// laat alle pagina's zien
$sql = "SELECT * FROM `".$tabelnaam."` ORDER BY `positie` ";
$result = $db->select($sql);
$rows = $db->row_count;

if ($rows >= 1) {
	echo '<h3>Overzicht</h3>'."\n";
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item" id="item_'.$lijst_id.'">
			<span class="handler"> &raquo; </span>
			<span class="status" title="Openbaar"><img src="img/icons/'.($status==1 ? 'publiek_16.png" alt="Openbaar"' : 'prive_16.png" alt="Priv&eacute;"').' align="absmiddle" /></span>
			<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id='.$lijst_id.'" class="titel mailing_lijst">'.$lijst_naam.'</a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$lijst_id.',\'verwijder\'); return false;"><img src="img/icons/item_delete_16.png" alt="verwijderen" /></a>'."\n";

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
	'.($add_delete ? '<a href="?pagina='.$_GET['pagina'].'&amp;content=item&amp;id=0"><img src="img/icons/nieuw_item_32.png" align="absmiddle" /> '.$item_titel.' toevoegen</a>' : '').'
</div>
';
?>
<div id="info" style="display:none;"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('.opsomming').sortable({
		revert: 200,
		placeholder: 'placeholder',
		opacity: .85,
		handle : '.handler',
		zIndex: 1000,
		update : function () {
			loader_show();
			var order = $('.opsomming').sortable('serialize');
			$('#info').load("wijzig_<?php echo $module_naam; ?>/ajax_verwerking.php?positie=1&"+order); 
			loader_hide();
		}
	});
});
</script>