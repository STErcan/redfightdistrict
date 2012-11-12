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
	<input name="datum" type="hidden" value="'.date("Y-m-d").'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=overzicht'.($_GET['old_tab'] ? '&tab='.$_GET['old_tab'] : '').'">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Abonnee informatie</td>
		</tr>
		<tr class="sub_lijn">
			<td>Naam</td>
			<td><input name="email_naam" type="text" class="text_veld" maxlength="128" size="40" value="'.$email_naam.'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Email adres</td>
			<td><input name="email_adres" type="text" class="text_veld" maxlength="128" size="40" value="'.$email_adres.'" /></td>
		</tr>
		<tr class="sub_lijn">
			<td>Email format</td>
			<td>
				<select name="email_type" class="text_veld">
					<option value="html" '.($email_type == 'html' ? $select : '').'>html</option>
					<option value="txt" '.($email_type == 'txt' ? $select : '').'>txt</option>
				</select>
			</td>
		</tr>
		<tr class="sub_lijn">
			<td>Status</td>
			<td>
				<select name="status" class="text_veld">
				';
				// privileges
				if (count($status_array)>0) {
					foreach($status_array as $key => $waarde) {
						echo '<option value="'.$key.'" '.($key == $status ? $select : '').'>'.$waarde.'</option>';
					}
				}
				echo '
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