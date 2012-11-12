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
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Preview</td>
		</tr>
		<tr class="sub_lijn">
			<td colspan="2">
			<a href="wijzig_mailing/preview.php?type=html&amp;id='.$pagina_id.'" class="iframe" title="html-preview">&raquo; Bekijk html-preview</a><br />
			<a href="wijzig_mailing/preview.php?type=txt&amp;id='.$pagina_id.'" class="iframe" title="txt-preview">&raquo; Bekijk txt-preview</a>
			</td>
		</tr>
	</table>
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Test Verzenden</td>
		</tr>
		<tr class="sub_titel">
			<td colspan="2">Ter controle wordt de nieuwsbrief eerst verstuurd naar onderstaand test-emailadres. <br />Controleer de inhoud van deze test-nieuwsbrief goed!</td>
		</tr>
		<tr class="sub_lijn">
			<td>Test emailadres</td>
			<td><input name="test_email" id="test_email" type="text" class="text_veld" maxlength="128" size="40" value="'.$cms_config['bedrijf_email'].'"></td>
		</tr>
		<tr class="lijn_leeg">
			<td>&nbsp;</td>
			<td id="save" style="text-align:left;">&nbsp;<a href="#" onclick="email_nieuwsbrief(\'test\','.$pagina_id.'); return false;">Verzend test-nieuwsbrief&nbsp;<img src="img/icons/brief_versturen_24.png" align="absmiddle" /></a>
			<div id="email_status_test"></div></td>
		</tr>
	</table>
';
?>
<script type="text/javascript">
	/* initialiseer fancy box */
	$(document).ready(function() {
		$("a.iframe").fancybox({ 
			'zoomOpacity': true,
			'frameWidth': 550, 
			'frameHeight': 500, 
			'overlayOpacity': .6
		});
		$("#test_email").focus();
	});
		
	function email_nieuwsbrief(status,id) {
		loader_show();
		var email = $('#test_email').val();
		if (status == 'test') {
			$.ajax({
				url: 'wijzig_<?php echo $module_naam; ?>/ajax_verwerking.php',
				data: 'actie=mailing&id='+id+'&status='+status+'&email='+email+'&d='+Date(),
				type: 'GET',
				enctype: 'multipart/form-data',
				success: function(feedback){
					$('#email_status_'+status).html(feedback);
					loader_hide();
				},
				error: function(){
					$('#email_status_'+status).html('kan email niet verzenden');
					loader_hide();
				}
			});
		} else if (status == 'def') {
			$('#email_status_'+status).html('<a class="iframe_nieuwsbrief" href="" title="Nieuwsbrief verzenden"></a>');
			$('.iframe_nieuwsbrief').attr('href','wijzig_<?php echo $module_naam; ?>/ajax_verwerking.php?actie=mailing&id='+id+'&status='+status+'&email='+email+'&iframe=1');
			$('.iframe_nieuwsbrief').fancybox({ 
				'zoomOpacity': true,
				'frameWidth': 350, 
				'frameHeight': 350, 
				'overlayOpacity': .6
			}).trigger('click');
		}
	}
</script>
