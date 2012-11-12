<?php
echo '<h3>Zoeken naar abonnees</h3>'."\n";
echo '
<form action="#" method="post" enctype="multipart/form-data" name="form">
	<table border="0" class="form algemeen">
		<colgroup>
			<col class="kop" style="width:120px;" />
			<col class="info" />
		</colgroup>
		<tr class="lijn">
			<td colspan="2">Gegevens</td>
		</tr>
		<tr class="sub_lijn">
			<td>Naam</td>
			<td><input name="email_naam" id="email_naam" type="text" class="text_veld" maxlength="128" size="40" value="'.$email_naam.'" onKeyUp="zoek_abonnee();" /></td>
		</tr>
		<tr class="sub_lijn">
			<td>Email adres</td>
			<td><input name="email_adres" id="email_adres" type="text" class="text_veld" maxlength="128" size="40" value="'.$email_adres.'" onKeyUp="zoek_abonnee();" /></td>
		</tr>
	</table>
</form>

<div id="zoek_resultaat"></div>

<div id="nieuw_item">
	<a href="?pagina=mailing_adressen&content=item&id=0&tab=omschrijving&old_tab=overzicht_zoeken"><img src="img/icons/nieuw_user_32.png" align="absmiddle"> abonnee toevoegen</a>
</div>

';
?>
<script language="javascript">
function zoek_abonnee() {
	loader_show();
	var email_naam = $("#email_naam").val();
	var email_adres = $("#email_adres").val();
	$.ajax({
		url: 'wijzig_<?php echo $tabelnaam; ?>/ajax_zoek_abonnee.php',
		data: 'email_naam='+email_naam+'&email_adres='+email_adres+'<?php echo '&pagina='.$_GET['pagina'].'&old_tab='.$_GET['tab']; ?>',
		type: 'GET',
		success: function(feedback){
			$("#zoek_resultaat").html(feedback);
		},
		complete: function(feedback){
			loader_hide();
		}
	});
}
</script>