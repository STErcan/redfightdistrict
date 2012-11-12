<?php
## -- safe sessie controle
if ($_GET['pagina'] != 'login' && $_GET['pagina'] != 'loguit') {
	
	// geen safe-id gevonden
	if (!$_SESSION['safe_'.$cms_config['token']]['id']) {
		if (!$_COOKIE['safe_'.$cms_config['token']]['id']) {
			// url bewaren
			$_SESSION['safe_'.$cms_config['token']] = array();
			$_SESSION['url_redirect'] = ($_SERVER['QUERY_STRING'] ? 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?'.$_SERVER['QUERY_STRING'] : '');
			header("Location:  index.php?pagina=login"); /* geen safe-sessie aanwezig, dus verwijzen naar login.php */
			exit();
		} else {
			$_SESSION['safe_'.$cms_config['token']]['id'] = $_COOKIE['safe_'.$cms_config['token']]['id'];
			$_SESSION['safe_'.$cms_config['token']]['priv'] = $_COOKIE['safe_'.$cms_config['token']]['priv'];
			$_SESSION['safe_'.$cms_config['token']]['naam'] = $_COOKIE['safe_'.$cms_config['token']]['naam'];
			$_SESSION['safe_'.$cms_config['token']]['sites'] = $_COOKIE['sites_'.$cms_config['token']];
			$_SESSION['safe_'.$cms_config['token']]['site_id'] = $_COOKIE['safe_'.$cms_config['token']]['site_id'];
		}
	} else {
		// reset cookies + updaten met huidige tijdspan:
		$cookie_tijd = 10800;
		setcookie('safe_'.$cms_config['token'].'[id]', $_SESSION['safe_'.$cms_config['token']]['id'], time()+$cookie_tijd);
		setcookie('safe_'.$cms_config['token'].'[priv]', $_SESSION['safe_'.$cms_config['token']]['priv'], time()+$cookie_tijd);
		setcookie('safe_'.$cms_config['token'].'[naam]', $_SESSION['safe_'.$cms_config['token']]['naam'], time()+$cookie_tijd);
		if (count($_SESSION['safe_'.$cms_config['token']]['sites'])>0) {
			foreach($_SESSION['safe_'.$cms_config['token']]['sites'] as $key => $waarde) {
				setcookie('sites_'.$cms_config['token'].'['.$key.']', $waarde, time()+$cookie_tijd);
			}
		}
		setcookie('safe_'.$cms_config['token'].'[site_id]', $_SESSION['safe_'.$cms_config['token']]['site_id'], time()+$cookie_tijd);
	}
} else {
	// cookies en sessies verwijderen
	setcookie('safe_'.$cms_config['token'].'[id]', '', time()-3600);
	setcookie('safe_'.$cms_config['token'].'[priv]', '', time()-3600);
	setcookie('safe_'.$cms_config['token'].'[naam]', '', time()-3600);
	if (count($_SESSION['safe_'.$cms_config['token']]['sites'])>0) {
		foreach ($_SESSION['safe_'.$cms_config['token']]['sites'] as $key => $waarde) {
			setcookie('sites_'.$cms_config['token'].'['.$key.']', '', time()-3600);
		}
	}
	setcookie('sites_'.$cms_config['token'].'', '', time()-3600);
	setcookie('safe_'.$cms_config['token'].'[site_id]', '', time()-3600);
	$_SESSION['safe_'.$cms_config['token']] = array();
}
?>