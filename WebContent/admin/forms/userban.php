<?php
## -- waardes
$toon_formulier = 1;

if($_GET['aktie'] == 'verwerk') {
	
	$toon_formulier = 0;
	include('../mailer/class.phpmailer.php');
	
	$bedrijfsnaam = sanitize($_POST['bedrijfsnaam']);
	$contactpersoon = sanitize($_POST['contactpersoon']);
	$telefoon = sanitize($_POST['telefoon']);
	$email = sanitize($_POST['email']);
	$ip_adres = $_SERVER['REMOTE_ADDR'];
	$url = sanitize($_POST['url']);

	// mailing
	$mail = new PHPMailer();
	$mail->IsHTML(true);
	$mail->FromName = $cms_config['bedrijf_naam'];
	$mail->From = $cms_config['bedrijf_email'];
	$mail->Subject = 'Aanvraag ip-adres deblokkade (brute force)';
	$mail->AddAddress($cms_config['brute_force_email'], $cms_config['bedrijf_naam']);
	$mail->Body = '
	<table border="0" cellspacing="2" cellpadding="1">
		<tr>
			<td class="label">Bedrijfsnaam:</td>
			<td class="field">'.$bedrijfsnaam.'</td>
		</tr>
		<tr>
			<td class="label">Contactpersoon:</td>
			<td class="field">'.$contactpersoon.'</td>
		</tr>
		<tr>
			<td class="label">Telefoon:</td>
			<td class="field">'.$telefoon.'</td>
		</tr>
		<tr>
			<td class="label">Email:</td>
			<td class="field">'.$email.'</td>
		</tr>
		<tr>
			<td class="label">Website URL:</td>
			<td class="field">'.$url.'</td>
		</tr>
		<tr>
			<td class="label">IP adres:</td>
			<td class="field">'.$ip_adres.'</td>
		</tr>
		<tr>
			<td class="label">Datum/tijd:</td>
			<td class="field">'.date('d-m-Y / H-i-s').'</td>
		</tr>
		<tr>
			<td colspan="2">Klik <a href="'.$url.'/admin">hier</a> om naar de admin te gaan.</td>
		</tr>
	</table>
	';
	
	if(!$mail->Send()) {
		echo '<b>Uw aanvraag is niet verstuurd. Probeert u het nogmaals.</b>'."\n";
	} else {
		echo 'Uw aanvraag is verstuurd. Wij nemen zo spoedig mogelijk contact met u op.'."\n";
		
		// update sql aanvraag verstuurd		
		$sql = "UPDATE `userban` SET ";
		$sql .= "`aanvraag` = '1' ";
		$sql .= "WHERE `ip_adres` = '".$_SERVER['REMOTE_ADDR']."' LIMIT 1";
		$db->update_sql($sql);
		
	}
}
## -- formulier
if($toon_formulier) {
	
	echo '
	Vul onderstaand formulier volledig in en wij nemen zo spoedig mogelijk contact met u op.<br /><br />
	<form enctype="multipart/form-data" name="form" action="?pagina='.$_GET['pagina'].'&amp;aktie=verwerk" method="post">
		<table border="0" cellspacing="1" cellpadding="1" id="inloggen">
			<tr>
				<td>Bedrijfsnaam *</td>
				<td><input type="text" name="bedrijfsnaam" class="text_veld" size="40" value="'.$cms_config['bedrijf_naam'].'" /></td>
			</tr>
			<tr>
				<td>Contactpersoon / gebruiker *</td>
				<td><input type="text" name="contactpersoon" class="text_veld" size="40" value="" /></td>
			</tr>
			<tr>
				<td>Telefoon *</td>
				<td><input type="text" name="telefoon" class="text_veld" size="15" value="" /></td>
			</tr>
			<tr>
				<td>Email *</td>
				<td><input type="text" name="email" class="text_veld" size="40" value="'.$cms_config['bedrijf_email'].'" /></td>
			</tr>
			<tr>
				<td>Website URL</td>
				<td><input type="text" name="url" class="text_veld" size="40" value="'.$cms_config['website_url'].'" /></td>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="button" value="verzenden" /></td>
			</tr>
		</table>
	</form>
	';
}
?>