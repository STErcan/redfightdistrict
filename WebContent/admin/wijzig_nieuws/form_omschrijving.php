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

// datum fix
$datum = ($datum ? $datum : date('Y-m-d'));

echo '
<form action="?pagina='.$_GET['pagina'].'&amp;content=verwerking&amp;id='.$_GET['id'].'" method="post" enctype="multipart/form-data" name="form">
	<input name="id" type="hidden" value="'.$pagina_id.'">
	<input name="tab" type="hidden" value="'.($_GET['tab'] != '' ? $_GET['tab'] : $eerste_tab).'">
	<input name="formactie" type="hidden" value="'.$formactie.'">
	<input name="redirect_url" type="hidden" value="'.$base_href.'admin/?pagina='.$_GET['pagina'].'&amp;content=overzicht&amp;type='.$_GET['type'].'">
	<input name="type" type="hidden" value="nieuws">
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
			<td><input name="datum" type="text" class="text_veld datum" maxlength="10" size="10" value="'.datum_nl($datum).'"></td>
		</tr>
		'.($zichtbaarheid ? '
		<tr class="sub_lijn">
			<td>Zichtbaarheid</td>
			<td><input name="datum_van" id="datum_van" type="text" class="text_veld datum" maxlength="10" size="10" value="'.datum_nl($datum_van).'">
			&nbsp; t/m &nbsp; <input name="datum_tot" id="datum_tot" type="text" class="text_veld datum" maxlength="10" size="10" value="'.datum_nl($datum_tot).'">
			</td>
		</tr>
		' : '').'
		<tr class="sub_lijn">
			<td>Titel</td>
			<td><input name="titel" type="text" class="text_veld" maxlength="128" size="60" value="'.$titel.'"></td>
		</tr>
		'.($nieuws_delen ? '
		<tr class="sub_lijn">
			<td>Tekst preview<br /><small style="line-height:1.4em;">Wij raden aan maximaal 1 paragraaf te gebruiken in verband met de leesbaarheid van het overzicht.</small></td>
			<td><textarea name="tekst_preview" id="editor_tekst_preview" style="height:200px;width:99%;color:#fff;">'.$tekst_preview.'</textarea></td>
		</tr>							
		' : '').'
		<tr class="sub_lijn">
			<td>Nieuwsbericht</td>
			<td><textarea name="tekst" id="editor_tekst" style="height:200px;width:99%;color:#fff;">'.$tekst.'</textarea></td>
		</tr>
		<tr class="lijn">
			<td colspan="2">Meta gegevens</td>
		</tr>
		<tr class="sub_lijn">
			<td>Permalink</td>
			<td>
			<div id="permalink_url">
			'.$base_href.permalink.'
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
		<tr class="sub_lijn">
			<td>Meta description</td>
			<td><input name="meta_descr" type="text" class="text_veld" maxlength="256" size="60" value="'.$meta_descr.'" /></td>
		</tr>
		<tr class="sub_lijn">
			<td>Meta keywords</td>
			<td><input name="meta_key" type="text" class="text_veld" maxlength="256" size="60" value="'.$meta_key.'" /> <small>(komma gescheiden)</small></td>
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
	// editors
	CreateEditor('tekst','Default','200');
	
	<?php if ($nieuws_delen) { ?>
	CreateEditor('tekst_preview','Basic','100');
	<?php } ?>
	});
</script>