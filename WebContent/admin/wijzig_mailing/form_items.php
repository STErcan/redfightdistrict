<?php
$sql = "SELECT * FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1)  {
	extract($db->get_row($result));
	$array_items = explode(',',$items);
	$formactie = 'wijzig';
	$submit_txt = 'Wijzigingen opslaan';
}

echo '
<form action="?pagina='.$_GET['pagina'].'&amp;content=verwerking&amp;id='.$_GET['id'].'" method="post" enctype="multipart/form-data" name="form">
	<input name="id" type="hidden" value="'.$_GET['id'].'">
	<input name="tab" type="hidden" value="'.$_GET['tab'].'">	
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=item&id='.$_GET['id'].'&tab=items">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Inhoud</td>
		</tr>
		<tr class="sub_lijn">
			<td>Nieuwsberichten</td>
			<td>
				<div id="labels" class="items">
';
if ($mailing_verzonden==1) {
	if ($items!='') {
		$sql = "SELECT * FROM `paginas` WHERE `pagina_id` IN (".implode(',',array_filter($array_items)).")  ORDER BY `datum` DESC";
		$result = $db->select($sql);
		$rows = $db->row_count;
		if ($rows >= 1) {
			for ($i=1; $i<=$rows; $i++) {
				$nieuws_item = $db->get_row($result);
				echo '
				<label for="lijst_'.$nieuws_item['pagina_id'].'">
				<input type="checkbox" id="lijst_'.$nieuws_item['pagina_id'].'" name="lijst_'.$nieuws_item['pagina_id'].'"'.(in_array($nieuws_item['pagina_id'],$array_items) ? $check : '').' value="'.$nieuws_item['pagina_id'].'" /> 
				<b>'.datum_nl($nieuws_item['datum']).' - '.$nieuws_item['titel'].'</b><br />
				<i>'.inkorten($nieuws_item['tekst'],185).'</i>
				</label>
				';
			}
		}
	} else {
		echo 'Er waren geen nieuwsberichten geselecteerd.';
	}

} else {
	$sql = "SELECT * FROM `paginas` WHERE `type` = 'nieuws' AND `site_id` = '".$_SESSION['safe_'.$cms_config['token']]['site_id']."' ORDER BY `datum` DESC LIMIT 0,20";
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows >= 1) {
		for ($i=1; $i<=$rows; $i++) {
			$nieuws_item = $db->get_row($result);
			echo '
			<label for="lijst_'.$nieuws_item['pagina_id'].'">
			<input type="checkbox" id="lijst_'.$nieuws_item['pagina_id'].'" name="lijst_'.$nieuws_item['pagina_id'].'"'.(in_array($nieuws_item['pagina_id'],$array_items) ? $check : '').' value="'.$nieuws_item['pagina_id'].'" /> 
			<b>'.datum_nl($nieuws_item['datum']).' - '.$nieuws_item['titel'].'</b><br />
			<i>'.inkorten($nieuws_item['tekst'],185).'</i>
			</label>
			';
		}
	}
}

echo '			</div>	
			</td>
		</tr>
	</table>
';
if ($mailing_verzonden!=1) {
	echo '
	<table border="0" class="form algemeen">
		<tr class="lijn_leeg">
			<td id="save"><input type="submit" class="button"  value="'.$submit_txt.'" /></td>
		</tr>
	</table>
	';
}
echo '
</form>
';
?>
<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		// maak labels actief
		check_labels('#labels');
	});
</script>
