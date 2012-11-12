<?php
## -- inlog verwerking
$_POST = sanitize($_POST,true); /* post-array opschonen */
$bf_teller = $_SESSION['bf_teller_'.$cms_config['token']];
$_SESSION['safe_'.$cms_config['token']] = array();  /* safe sessie verwijderen */

// inloggegevens controleren
$sql = "SELECT `user_id`,`user_priv`,`user_naam` FROM `users` WHERE `user_login` = '".$_POST['login_naam']."' 
AND `user_pass` = SHA1(CONCAT('".$_POST['login_wachtwoord']."','+',`user_id`)) LIMIT 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
// gebruiker bestaat en login is correct
if ($rows == 1) {
	extract($db->get_row($result));
	$_SESSION['safe_'.$cms_config['token']]['id'] = $user_id;
	$_SESSION['safe_'.$cms_config['token']]['priv'] = $user_priv;		
	$_SESSION['safe_'.$cms_config['token']]['naam'] = $user_naam;		
	
	setcookie('safe_'.$cms_config['token'].'[id]', $user_id, time()+10800);
	setcookie('safe_'.$cms_config['token'].'[priv]', $user_priv, time()+10800);
	setcookie('safe_'.$cms_config['token'].'[naam]', $user_naam, time()+10800);

	// check site rechten (verplicht)
	$sql_user = "SELECT * FROM `users_2_sites` 
	JOIN `sites` ON (`sites`.`site_id` = `users_2_sites`.`site_id`)
	WHERE `user_id` = '".$user_id."' ORDER BY `sites`.`positie`";
	$result_user  = $db->select($sql_user);
	$rows_user  = $db->row_count;
	if ($rows_user >= 1) {
		for ($i=1; $i<=$rows_user; $i++) {
			extract($db->get_row($result_user));
			$_SESSION['safe_'.$cms_config['token']]['sites'][$i] = $site_id;
			setcookie('sites_'.$cms_config['token'].'['.$i.']', $site_id, time()+10800);
		}
	
		// LET OP: de user MOET aan een site_id gekoppeld zijn!
		// 1e uit array gebruiken voor site-id start
		$_SESSION['safe_'.$cms_config['token']]['site_id'] = $_SESSION['safe_'.$cms_config['token']]['sites'][1];
		setcookie('safe_'.$cms_config['token'].'[site_id]', $_SESSION['safe_'.$cms_config['token']]['site_id'], time()+10800);
	} else {
		// user is niet gekoppeld aan site_id
	}
	
	
	// brute force
	$_SESSION['bf_teller_'.$cms_config['token']] = 0; 

	// clear cropmappen
	require_once('plugin_cropper/config.php');
	require_once('plugin_cropper/clear_crop.php');
		
	// opschonen files map
	require('files_cleanup.php'); 
	
	// redirect naar homepage
	if($_SESSION['url_redirect']!='') {
		header('Location: '.$_SESSION['url_redirect'].'');
	} else {
		header('Location: index.php?pagina=home');
	}
	exit();

// gebruiker bestaat niet of login is incorrect
} else {
	
	// set bruteforce sessie
	/* de brute force sessie werkt niet meer, graag opnieuw controleren // JE 2010-07-23 */
	if(!$bf_teller || $bf_teller == 0) {
		$_SESSION['bf_teller_'.$cms_config['token']] = 1;
	} else {
		$_SESSION['bf_teller_'.$cms_config['token']] = ($bf_teller+1);
	}

	// blokkeer ip-adres wanneer meer dan 5 keer verkeerd ingelogd
	if ($bf_teller >= 5) {
		
		// update sql blokkade
		$sql = "INSERT INTO `userban` (id, timestamp, ip_adres, blokkeer) ";
		$sql .= "VALUES (NULL, NOW(), '".$_SERVER['REMOTE_ADDR']."', 1) ";
		$db->update_sql($sql);		
	}
}
?>