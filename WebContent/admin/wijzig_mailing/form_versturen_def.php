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
	<div id="def_versturen" style="display:block;">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Definitief Verzenden</td>
		</tr>
		<tr class="sub_titel">
			<td colspan="2">Als u de nieuwsbrief voldoende heeft getest en gecontroleerd, <br />dan kunt u met een druk op de onderstaande knop de nieuwsbrief definitief versturen.</td>
		</tr>
		<tr class="lijn_leeg">
			<td>&nbsp;</td>
			<td id="save" style="text-align:left;">&nbsp;<a href="#" onclick="email_nieuwsbrief(\'def\','.$pagina_id.'); return false;">Verzend nieuwsbrief&nbsp;<img src="img/icons/brief_versturen_24.png" align="absmiddle" /></a></td>
		</tr>
		<tr class="lijn_leeg">
			<td colspan="2"><div id="email_status_def"></div></td>
		</tr>
	</table>
	</div>
';
?>
<script type="text/javascript">
	/* initialiseer fancy box */
	$(document).ready(function() {
		$("a.iframe").fancybox({ 
			'zoomOpacity': true,
			'width': 550, 
			'height': 500, 
			'overlayOpacity': .6
		});
		$("#test_email").focus();
	});
		
	function email_nieuwsbrief(status,id) {
		loader_show();
		var email = $('#test_email').val();
		 if (status == 'def') {
			$('#email_status_'+status).html('<a class="iframe_nieuwsbrief" href="" title="Nieuwsbrief verzenden"></a>');
			$('.iframe_nieuwsbrief').attr('href','wijzig_<?php echo $module_naam; ?>/ajax_verwerking.php?actie=mailing&id='+id+'&status='+status+'&email='+email+'&iframe=1');
			$('.iframe_nieuwsbrief').fancybox({ 
				'zoomOpacity': true,
				'width': 350, 
				'height': 350, 
				'overlayOpacity': .6
			}).trigger('click');
		}
	}
</script>
