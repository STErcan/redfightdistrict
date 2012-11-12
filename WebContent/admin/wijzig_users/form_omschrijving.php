<?php
$sql = "SELECT * FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1) {
	extract($db->get_row($result));
	$formactie = 'wijzig';
	$submit_txt = 'Wijzigingen opslaan';
} else {
	$formactie = 'nieuw';
	$submit_txt = 'Gegevens opslaan';
}

echo '
<form action="?pagina='.$_GET['pagina'].'&amp;content=verwerking&amp;id='.$_GET['id'].'" method="post" enctype="multipart/form-data" name="form">
	<input name="id" type="hidden" value="'.$user_id.'">
	<input name="tab" type="hidden" value="'.($_GET['tab'] != '' ? $_GET['tab'] : $eerste_tab).'">
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=overzicht">
	<input name="datum" type="hidden" value="'.date("Y-m-d").'">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Userdata</td>
		</tr>
		<tr class="sub_lijn">
			<td>Naam</td>
			<td><input name="user_naam" type="text" class="text_veld" maxlength="40" size="30" value="'.$user_naam.'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Loginnaam</td>
			<td><input name="user_login" type="text" class="text_veld" maxlength="20" size="20" value="'.$user_login.'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Wachtwoord</td>
			<td><input name="user_pass" type="text" class="text_veld" maxlength="20" size="20" value="" /> &nbsp; (alleen invullen om te wijzigen)</td>
		</tr>
		<tr class="sub_lijn">
			<td>Gebruikersrecht</td>
			<td>
				<select name="user_priv" class="text_veld">
				';
				// privileges
				if (count($priv_array)>0) {
					foreach($priv_array as $key => $waarde) {
						echo '<option value="'.$key.'" '.($key == $user_priv ? $select : '').'>'.$waarde.'</option>';
					}
				}
				echo '
				</select>
			</td>
		</tr>
		<tr class="lijn">
			<td colspan="2">Algemene info</td>
		</tr>
		<tr class="sub_lijn">
			<td>Opmerking</td>
			<td><textarea name="user_opm" id="editor_user_opm" style="height:200px;width:99%;color:#fff;">'.$user_opm.'</textarea></td>
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
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	CreateEditor('user_opm','Basic','200');
});
</script>