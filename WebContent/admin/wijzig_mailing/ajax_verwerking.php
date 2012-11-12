<?php
include('../ajax_header.php');
include('config.php');

// posities verwerken
if ($_GET['positie'] == 1) {
	// array uitlezen
	if (count($_GET['item'])>1) {
		foreach ($_GET['item'] as $key => $waarde) {
			$sql = "UPDATE `".$tabelnaam."` SET `positie` = '".$key."' WHERE `".$prefix."id` = '".$waarde."' LIMIT 1";
			$affected_rows = $db->update_sql($sql);
		}
	}
	$melding = 'Posities zijn gewijzigd.';
}



// verwijderen
if ($_GET['verwijder'] == 1) {
	// item verwijderen
	$sql = "DELETE FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 1 ";
	$affected_rows = $db->update_sql($sql);
	
	$melding = $item_pre.' '.$item_titel.' is verwijderd.';
}

// mailing
if ($_GET['actie'] == 'mailing') {
	require_once('../../includes/class.phpmailer.php');

	// haal nieuwsbrief informatie op
	$sql = "SELECT * FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 0,1";
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows == 1)  {
		$info = $db->get_row($result);
		$array_lijsten_mailing = explode(',',$info['email_lijst']);
		$array_items = array_filter(explode(',',$info['items']));
	}

	// extra inhoud (items)
	if (count($array_items)>0) {
		$content_items['txt'] = "\n";
		$content_items['html'] = '';
		foreach ($array_items as $key => $waarde) {
			$sql_items = "
			SELECT * FROM `paginas` 
			LEFT JOIN `files` ON ((`files`.`check_id` = `paginas`.`pagina_id`) && (`files`.`check_type` LIKE '%nieuws_foto_2%'))
			WHERE `paginas`.`pagina_id` = '".$waarde."' LIMIT 0,1
			";
			$result_items = $db->select($sql_items);
			$rows_items = $db->row_count;
			if ($rows_items == 1)  {
				$nieuws_item = $db->get_row($result_items);
				$afbeelding = ($nieuws_item['naam'] ? $upload_dir['base'].$nieuws_item['dir'].$nieuws_item['naam'] : $upload_dir['base'].'img/pixel.gif');
				$content_items['txt'] .= sprintf($item_txt, $nieuws_item['titel'], inkorten($nieuws_item['tekst'],250), $upload_dir['base'].'nieuwsbrief.php?item_id='.$nieuws_item['pagina_id']);
				$content_items['html'] .= sprintf($item_html, $afbeelding, $nieuws_item['titel'], inkorten($nieuws_item['tekst'],250), $upload_dir['base'].'nieuwsbrief.php?item_id='.$nieuws_item['pagina_id']);
			}
		}
	}

	
	// test mailing
	if ($_GET['email'] && $_GET['status'] == 'test') {
		
		// intro tekst
		$datum = date('d-m-Y');
		$intro['html'] = sprintf($intro_html,'test ontvanger',$datum);
		$intro['txt'] = sprintf($intro_txt,'test ontvanger',$datum);
		
		// afmeld link
		$sha_key = sha1($_GET['email'].'+'.(1809));
		$afmeld_url_def = sprintf($afmeld_url,urlencode($_GET['email']),urlencode($sha_key));
		$afmelden['html'] = sprintf($afmelden_html,$afmeld_url_def,$afmeld_url_def);
		$afmelden['txt'] = sprintf($afmelden_txt,$afmeld_url_def);


		// txt versie
		$template = $intro['txt'];
		$template .= html_entity_decode($info['tekst_txt']);
		$template .= html_entity_decode($content_items['txt']);
		$template .= $afmelden['txt'];
		
		$mail = new PHPMailer();
		$mail->IsHTML(false);
		$mail->IsMail();
		$mail->FromName = $cms_config['bedrijf_naam'];
		$mail->From = $cms_config['nieuwsbrief_email'];
		$mail->Subject = $info['titel'];
		$mail->AddAddress($_GET['email'],'test ontvanger');
		$mail->Body = $template;
		if ($mail->Send()) {
			$status_txt = true;
		}
		
		// html versie
		$template = file_get_contents('../../'.$upload_dir['base_templates'].$array_templates[$info['template']]);
		$template = str_replace('@@INTRO@@',$intro['html'],$template);
		$template = str_replace('@@CONTENT@@',$info['tekst_html'],$template);
		$template = str_replace('@@CONTENT_ITEMS@@',$content_items['html'],$template);
		$template = str_replace('@@AFMELDEN@@',$afmelden['html'],$template);
		
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		$mail->IsMail();
		$mail->FromName = $cms_config['bedrijf_naam'];
		$mail->From = $cms_config['mailing_email'];
		$mail->Subject = $info['titel'];
		$mail->AddAddress($_GET['email'],'test ontvanger');
		$mail->Body = $template;
		if ($mail->Send()) {
			$status_html = true;
		}
		
		if ($status_html == true && $status_txt == true) {
			echo 'Verstuurd <small>('.date('H:i:s').')</small>';
		} else {
			echo 'NIET verstuurd, controleer het emailadres en probeer het opnieuw.';
		}
	
	
	// definitieve mailing
	} else if ($_GET['status'] == 'def') {
		
		// opmaak iframe
		echo '
		<style>
		body {
			font-family: verdana;
			font-size:.8em;
			line-height:1.4em;
		}
		</style>
		<b>Emails worden verstuurd...</b><br />
		';
		
		// abonnee's ophalen
		$sql = "SELECT * FROM `mailing_adressen` WHERE `status` = 0 ORDER BY `email_adres`";
		$result = $db->select($sql);
		$rows = $db->row_count;
		
		if ($rows >= 1) {
			for ($i=1; $i<=$rows; $i++) {
				extract($db->get_row($result));
				$array_lijsten_hits = array(); // reset
				$array_lijsten_user = explode(',',$email_lijst);
				$array_lijsten_hits = array_filter(array_intersect($array_lijsten_mailing, $array_lijsten_user));
				
				// intro tekst
				$datum = date('d-m-Y');
				$intro['html'] = sprintf($intro_html,$email_naam,$datum);
				$intro['txt'] = sprintf($intro_txt,$email_naam,$datum);
				
				// afmeld link
				$sha_key = sha1($email_adres.'+'.$email_id);
				$afmeld_url_def = sprintf($afmeld_url,urlencode($email_adres),urlencode($sha_key));
				$afmelden['html'] = sprintf($afmelden_html,$afmeld_url_def,$afmeld_url_def);
				$afmelden['txt'] = sprintf($afmelden_txt,$afmeld_url_def);
				
				if (count($array_lijsten_hits)>0) {
					// meer dan 1 hit, dus versturen
					
					// html versie
					if ($email_type == 'html') {
						$template = file_get_contents('../../'.$upload_dir['base_templates'].$array_templates[$info['template']]);
						$template = str_replace('@@INTRO@@',$intro['html'],$template);
						$template = str_replace('@@CONTENT@@',$info['tekst_html'],$template);
						$template = str_replace('@@CONTENT_ITEMS@@',$content_items['html'],$template);
						$template = str_replace('@@AFMELDEN@@',$afmelden['html'],$template);
						
						$mail = new PHPMailer();
						$mail->IsHTML(true);
						$mail->IsMail();
						$mail->FromName = $cms_config['bedrijf_naam'];
						$mail->From = $cms_config['mailing_email'];
						$mail->Subject = $info['titel'];
						$mail->AddAddress($email_adres, $email_naam);
						$mail->Body = $template;
						if ($mail->Send()) {
							$status_html = true;
						}
						//echo $template;
						echo '<div id="bottom_'.$email_id.'">';
						if ($status_html == true) {
							echo $email_adres.'... OK';
						} else {
							echo $email_adres.'... Niet verstuurd';
						}
						echo '</div>'."\n";
					}
					
					// txt versie
					if ($email_type == 'txt') {
						$template = $intro['txt'];
						$template .= $info['tekst_txt'];
						$template .= $content_items['txt'];
						$template .= $afmelden['txt'];
						
						$mail = new PHPMailer();
						$mail->IsHTML(false);
						$mail->IsMail();
						$mail->FromName = $cms_config['bedrijf_naam'];
						$mail->From = $cms_config['mailing_email'];
						$mail->Subject = $info['titel'];
						$mail->AddAddress($email_adres, $email_naam);
						$mail->Body = $template;
						if ($mail->Send()) {
							$status_txt = true;
						}
						//echo $template;
						echo '<div id="bottom_'.$email_id.'">';
						if ($status_txt == true) {
							echo $email_adres.'... OK';
						} else {
							echo $email_adres.'... Niet verstuurd';
						}
						echo '</div>'."\n";
					}
					
					// sleep functie en time limit
					flush();
					ob_flush();					
					set_time_limit(60);
					usleep(150000);
					

				}


			}
		

			// update verzend-status van nieuwsbrief
			$sql_update = "UPDATE `".$tabelnaam."` SET `status` = '1' WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 1";
			$affected_rows = $db->update_sql($sql_update);

			echo '<b>KLAAR. U kunt het venster sluiten!</b><br /><br />
			<script type="text/javascript">
				$(document).ready(function() {
					parent.window.loader_hide();
				});
			</script>
			';
		
		}

		
	}
}

?>