<?php
$sql = "SELECT * FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."'";
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
	<input name="id" type="hidden" value="'.$_GET['id'].'">
	<input name="tab" type="hidden" value="'.($_GET['tab'] != '' ? $_GET['tab'] : $eerste_tab).'">
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=overzicht">
	<input name="datum" type="hidden" value="'.date("Y-m-d").'">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="sub_lijn">
			<td>Lijstnaam</td>
			<td><input name="lijst_naam" type="text" class="text_veld" maxlength="128" size="40" value="'.$lijst_naam.'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Status</td>
			<td>
			<select name="status" class="text_veld">
				<option value="1" '.($status == 1 ? $select : '').'>Openbaar</option>
				<option value="0" '.($status == 0 ? $select : '').'>Priv&eacute;</option>
			</select>
			</td>
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