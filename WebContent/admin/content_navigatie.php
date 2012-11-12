<?php
## -- linker navigatie menu 

// support club menu
$support_menu[] = array('algemeen_titel','titel','Algemeen');
$support_menu[] = array('paginas','link','Supportclub','supportclub');

// user menu
$user_menu[] = array('algemeen_titel','titel','Algemeen');
if (count($array_pagina_types)>0) {
	foreach ($array_pagina_types as $key => $waarde) {
		$user_menu[] = array('paginas','link',$waarde,$key);
	}
}
$user_menu[] = array('spacer','spatie','');
$user_menu[] = array('nieuws','link','Nieuwsberichten');


// poweruser menu
$poweruser_menu = array(
	array('spacer','spatie',''),
	array('config_titel','titel','Configuratie'),
	array('configuratie','link','Configuratie'),
);

// root menu
$administrator_menu = array(
	array('spacer','spatie',''),
	array('beheer_titel','titel','Beheer'),
	array('users','link','Users'),
	array('userban','link','IP blokkade (bruteforce)'),
	
	array('spacer','spatie',''),
	array('config_titel','titel','Configuratie'),
	array('configuratie','link','Configuratie'),
	array('sites','link','Sites'),
);

// maak menu
if ($_SESSION['safe_'.$cms_config['token']]['site_id']) {
	
	if ($_SESSION['safe_'.$cms_config['token']]['priv']==3) {
		$menu = $user_menu;
		maak_menu($menu);
	
	} else if ($_SESSION['safe_'.$cms_config['token']]['priv']==2) {
		$menu = array_merge($user_menu, $poweruser_menu);
		maak_menu($menu);
	
	} else if ($_SESSION['safe_'.$cms_config['token']]['priv']==1) {
		$menu = array_merge($user_menu, $administrator_menu);
		maak_menu($menu);
	} else if ($_SESSION['safe_'.$cms_config['token']]['priv']==4) {
		maak_menu($support_menu);
		
	}
}
?>