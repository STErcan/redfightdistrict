<?php
$sql = "SELECT * FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1)  {
	extract($db->get_row($result));
	$formactie = 'wijzig';
	$submit_txt = 'Wijzigingen opslaan';
} else {
	$formactie = 'nieuw';
	$submit_txt = 'Gegevens opslaan';
}

echo '
<form action="?pagina='.$_GET['pagina'].'&amp;content=verwerking&amp;id='.$_GET['id'].'" method="post" enctype="multipart/form-data" name="form">
	<input name="id" type="hidden" value="'.$config_id.'">
	<input name="tab" type="hidden" value="'.($_GET['tab'] != '' ? $_GET['tab'] : $eerste_tab).'">
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=overzicht">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="sub_lijn">
			<td>Item</td>
			<td><input name="config_item" type="text" class="text_veld" maxlength="20" size="15" value="'.$config_item.'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Omschrijving</td>			
			<td><input name="config_omschrijving" type="text" class="text_veld" size="50" value="'.$config_omschrijving.'"></td>			
		</tr>
	</table>
	<table border="0" class="form algemeen">
		<tr class="lijn_leeg">
			<td id="save"><input type="submit" class="button"  value="'.$submit_txt.'" /></td>
		</tr>
	</table>
</form>
';
?>