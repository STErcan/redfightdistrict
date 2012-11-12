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

// datum fix
$datum = ($datum ? $datum : date('Y-m-d'));

echo '
<form action="?pagina='.$_GET['pagina'].'&amp;content=verwerking&amp;id='.$_GET['id'].'" method="post" enctype="multipart/form-data" name="form">
	<input name="id" type="hidden" value="'.$reactie_id.'">
	<input name="tab" type="hidden" value="'.($_GET['tab'] != '' ? $_GET['tab'] : $eerste_tab).'">
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="type" type="hidden" value="'.$type.'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=overzicht'.($_GET['old_tab'] ? '&amp;tab='.$_GET['old_tab'] : '').'">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Algemene informatie</td>
		</tr>
		<tr class="sub_lijn">
			<td>Datum</td>
			<td>'.datum_nl($datum).'</td>
		</tr>
		<tr class="sub_lijn">
			<td>Status</td>
			<td>
				<select name="status" class="text_veld">
					<option value="0"'.($status == 0 ? $select : '').'>Onzichtbaar (nieuw)</option>
					<option value="1"'.($status == 1 ? $select : '').'>Zichtbaar</option>
				</select>
			</td>
		</tr>
		<tr class="sub_lijn">
			<td>Auteur</td>
			<td><input name="auteur_naam" type="text" class="text_veld" maxlength="128" size="40" value="'.$auteur_naam.'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Auteur email</td>
			<td><input name="auteur_email" type="text" class="text_veld" maxlength="128" size="40" value="'.$auteur_email.'"></td>
		</tr>
<!--		<tr class="sub_lijn">
			<td>Titel</td>
			<td><input name="titel" type="text" class="text_veld" maxlength="128" size="60" value="'.$titel.'"></td>
		</tr>-->
		<tr class="sub_lijn">
			<td>Opmerking</td>
			<td><textarea name="tekst" id="editor_tekst" style="height:200px;width:99%;color:#fff;">'.$tekst.'</textarea></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="4" class="form algemeen">
		<tr class="lijn_leeg">
			<td id="save"><a href="#" onclick="submit_form(\'form\');return false;">'.$submit_txt.'&nbsp;<img src="img/icons/save_24.png" align="absmiddle" border="0"></a></td>
		</tr>
	</table>
</form>
';
?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	// editors
	CreateEditor('tekst','Basic','200');
});
</script>