<?php
$sql = "SELECT * FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1)  {
	extract($db->get_row($result));
	$array_lijsten = explode(',',$email_lijst);
	$formactie = 'wijzig';
	$submit_txt = 'Wijzigingen opslaan';
} else {
	$array_lijsten = array();
	$formactie = 'nieuw';
	$submit_txt = 'Gegevens opslaan';
}

// datum fix
$datum = ($datum ? $datum : date('Y-m-d'));

echo '
<form action="?pagina='.$_GET['pagina'].'&amp;content=verwerking&amp;id='.$_GET['id'].'" method="post" enctype="multipart/form-data" name="form">
	<input name="id" type="hidden" value="'.$_GET['id'].'">
	<input name="tab" type="hidden" value="'.($_GET['tab'] != '' ? $_GET['tab'] : $eerste_tab).'">
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="datum" type="hidden" value="'.date("Y-m-d").'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=overzicht">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Inhoud</td>
		</tr>
		<tr class="sub_lijn">
			<td>Titel</td>
			<td><input name="titel" type="text" class="text_veld" maxlength="128" size="60" value="'.$titel.'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Tekst HTML</td>
			<td><textarea name="tekst_html" id="editor_tekst_html" style="height:200px;width:98%;color:#fff;">'.$tekst_html.'</textarea></td>
		</tr>
		<tr class="sub_lijn">
			<td>Tekst TXT</td>
			<td><textarea name="tekst_txt" style="height:200px;width:98%;">'.$tekst_txt.'</textarea></td>
		</tr>
		<tr class="lijn">
			<td colspan="2">Algemene informatie</td>
		</tr>
		<tr class="sub_lijn">
			<td>Template</td>
			<td>
				<select name="template" class="text_veld">
';
if (count($array_templates)>0) {
	foreach ($array_templates as $key => $waarde) {
		echo '<option value="'.$key.'"'.($key==$template ? $select : '').'>'.$waarde.'</option>'."\n";
	}
}
echo '
				</select>
			</td>
		</tr>
		<tr class="sub_lijn">
			<td>Afzender</td>
			<td><input name="afzender_naam" type="text" class="text_veld" maxlength="128" size="40" value="'.($afzender_naam ? $afzender_naam : $cms_config['bedrijf_naam']).'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Afzender email</td>
			<td><input name="afzender_email" type="text" class="text_veld" maxlength="128" size="40" value="'.($afzender_email ? $afzender_email : $cms_config['nieuwsbrief_email']).'"></td>
		</tr>
		<tr class="sub_lijn">
			<td>Mailing lijsten</td>
			<td>
				<div id="labels">
';
$sql = "SELECT * FROM `mailing_lijsten` ORDER BY `positie`, `lijst_naam`";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		echo '<label for="lijst_'.$lijst_id.'"><input type="checkbox" id="lijst_'.$lijst_id.'" name="lijst_'.$lijst_id.'"'.(in_array($lijst_id,$array_lijsten) ? $check : '').' value="'.$lijst_id.'" /> '.$lijst_naam.'</label>'."\n";
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
$(document).ready(function(){
	CreateEditor('tekst_html','Default','300');
	check_labels('#labels');
});
</script>