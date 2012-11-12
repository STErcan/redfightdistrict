<?php
// laat alle pagina's zien
$sql = "SELECT * FROM `".$tabelnaam."`WHERE `type` = '".$_GET['type']."' AND `site_id` = '".$_SESSION['safe_'.$cms_config['token']]['site_id']."' ORDER BY `".($_GET['type']=='events' ? 'datum' : 'positie')."` ";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	echo '<h3>Overzicht</h3>'."\n";
	echo '<ul class="opsomming">'."\n";
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '
		  <li class="item" id="item_'.$pagina_id.'">
			<span class="handler"> &raquo; </span>
			<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id='.$pagina_id.'" class="titel">'.($_GET['type']=='events' ? datum_nl($datum).' - ' : '').''.$titel.'</a>
		';
		if ($add_delete) {
			echo '<a class="delete" href="#" onClick="verwerk_item('.$pagina_id.',\'verwijder\'); return false;"><img src="img/icons/document_close_16.png" alt="verwijderen" /></a>'."\n";
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
	'.($add_delete ? '<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id=0"><img src="img/icons/document_add_32.png" align="absmiddle" /> '.$item_titel.' toevoegen</a>' : '').'
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