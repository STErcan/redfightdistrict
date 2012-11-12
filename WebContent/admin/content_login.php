<?php 
echo '<h2>Inloggen</h2><br>'."\n";

// check ip blokkade (bruteforce)
$sql = "SELECT * FROM `userban` WHERE `ip_adres` = '".$_SERVER['REMOTE_ADDR']."' AND `blokkeer` = 1 LIMIT 0,1 ";
$result = $db->select($sql);
$rows = $db->row_count;

// gebruiker geblokkeerd
if ($rows == 1) {
	extract($db->get_row($result));
	echo '<div id="melding"><b>U heeft te vaak een verkeerde inlog gebruikt.</b><br /> U kunt helaas niet meer inloggen.<br /></div>'."\n";
	
	// aanvraag formulier
	if ($aanvraag == 0) {
		require_once('forms/userban.php');
	
	// aanvraag formulier is reeds verstuurd
	} else {
		$melding .= '<b>Uw aanvraag is reeds verstuurd.</b> Wij nemen zo spoedig mogelijk contact met u op.<br />'."\n";
	}

} else {

	// melding weergevem
	if ($_SESSION['bf_teller_'.$cms_config['token']]>0) {
		$melding .= '<b>De combinatie inlognaam - wachtwoord is niet correct.</b><br />';	
	}
	
	// aantal pogingen laten zien
	$aantal_pogingen = 5;
	if ($_SESSION['bf_teller_'.$cms_config['token']] == $aantal_pogingen) {
		$melding .= '(laatste poging)'."\n";
	} else if ($_SESSION['bf_teller_'.$cms_config['token']] != 0) {
		$melding .= '(poging '.$_SESSION['bf_teller_'.$cms_config['token']].'/'.$aantal_pogingen.')'."\n";
	}
	
	if ($melding!='') {
		echo '<div id="melding">'.$melding.'</div>'."\n";
	}
	
	// inlogformulier
	echo '
    <form method="post" action="?pagina=home" name="login_form">
	  <input type="hidden" name="url_redirect" value="'.$_SESSION['url_redirect'].'">
      <table border="0" cellspacing="0" cellpadding="0" class="form inloggen">
        <tr class="sub_lijn">
          <td>Gebruikersnaam</td>
          <td><input type="text" class="text_veld" name="login_naam" id="login_naam" size="20" maxlength="50"></td>
        </tr>
        <tr class="sub_lijn">
          <td>Wachtwoord</td>
          <td><input type="password" class="text_veld" name="login_wachtwoord" maxlength="50"></td>
        </tr>
        <tr class="lijn_leeg">
          <td id="save" colspan="2"><input type="hidden" name="login_actie" value="go">
			<input type="submit" class="button"  value="Inloggen &raquo;" />
		  </td>
        </tr>
      </table>
    </form>
	';
}
?>
<script>
$(function() {
	$("#login_naam").focus();
});
</script>