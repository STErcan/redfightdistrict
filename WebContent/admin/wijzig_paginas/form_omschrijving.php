<?php
$sql = "SELECT * FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1)  {
	extract($db->get_row($result));
	$formactie = 'wijzig';
	$submit_txt = 'Wijzigingen opslaan';
	
	// - extra velden shizz ophalen
	$sql = "SELECT * FROM `".$tabelnaam."_data` WHERE `parent_id` = '".$_GET['id']."'";
	$resultaat = mysql_query($sql) or die ("|$sql|:" . mysql_error());
	$aantal = mysql_num_rows($resultaat);
	if ($aantal >= 1) {
		for ($i=1; $i<=$aantal; $i++) {
			$array_datavelden = (mysql_fetch_array($resultaat));
			$$array_datavelden['type'] = $array_datavelden['waarde'];
		}
	}
} else {
	$formactie = 'nieuw';
	$submit_txt = 'Gegevens opslaan';
}

echo '
<form action="?pagina='.$_GET['pagina'].'&amp;content=verwerking&amp;id='.$_GET['id'].'" method="post" enctype="multipart/form-data" name="form">
	<input name="id" type="hidden" value="'.$pagina_id.'">
	<input name="tab" type="hidden" value="'.($_GET['tab'] != '' ? $_GET['tab'] : $eerste_tab).'">
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="type" type="hidden" value="'.$_GET['type'].'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=overzicht">
	<input name="datum" type="hidden" value="'.date("Y-m-d").'">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Algemene info</td>
		</tr>
		<tr class="sub_lijn">
			<td>Titel</td>
			<td><input name="titel" type="text" class="text_veld" maxlength="128" size="60" value="'.$titel.'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Tekst</td>
			<td><div class="editorBorder"><textarea name="tekst" id="editor_tekst" style="height:200px;width:99%;color:#fff;">'.$tekst.'</textarea></div></td>
		</tr>
		<tr class="lijn">
			<td colspan="2">Meta gegevens</td>
		</tr>
';
if ($edit_meta_url) {
	echo '
		<tr class="sub_lijn">
			<td>Permalink</td>
			<td>
			<div id="permalink_url">
			'.$base_href.''.$array_pagina_types_permalink[$_GET['type']].'
			<span id="permalink_container">
			<span class="permalink">'.inkorten_midden($meta_url,31).'</span>
			<input name="meta_url" type="text" class="text_veld permalink" maxlength="128" size="36" value="'.$meta_url.'">
			</span>
			/
			</div>
			<a href="#" id="wijzig_permalink" onclick="return false;"><img src="img/icons/edit_16.png" align="absmiddle" />bewerken</a>
			<a href="#" id="save_permalink" onclick="return false;"><img src="img/icons/save_16.png" align="absmiddle" />ok</a>&nbsp;
			<a href="#" id="cancel_permalink" onclick="return false;"><img src="img/icons/cancel_16.png" align="absmiddle" />annuleren</a>
			</td>
		</tr>
	';
} else {
	echo '
			<input name="meta_url" type="hidden" maxlength="128" size="36" value="'.$meta_url.'">
	';
}
echo '
		<tr class="sub_lijn">
			<td>Meta description</td>
			<td><input name="meta_descr" type="text" class="text_veld" maxlength="256" size="60" value="'.$meta_descr.'" /></td>
		</tr>
		<tr class="sub_lijn">
			<td>Meta keywords</td>
			<td><input name="meta_key" type="text" class="text_veld" maxlength="256" size="60" value="'.$meta_key.'" /> <small>(komma gescheiden)</small></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="4" class="form algemeen">
		<tr class="lijn_leeg">
			<td id="save"><input type="submit" class="button"  value="'.$submit_txt.'" /></td>
		</tr>
	</table>
</form>
';
?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	CreateEditor('tekst','Default','250');
});
</script>