<?php
## -- server instelling
$lokaal = ($_SERVER["SERVER_ADDR"]=='100.200.200.80' ? true : false);

## -- mysql data: 
if ($lokaal == true) {
	// lokaal
	$array_dbvars = array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'database' => 'redfightdistrict',
		'debug' => true,
	);
	$base_map = '/redfightdistrict.com/';
	$base_href = 'http://'.$_SERVER['HTTP_HOST'].$base_map;
} else {
	// website
	$array_dbvars = array(
		'host' => 'localhost',
		'username' => 'jur_kerk',
		'password' => '!trolol',
		'database' => 'cms_rfd',
		'debug' => true,
	);
	$base_map = '/';
	$base_href = 'http://'.$_SERVER['HTTP_HOST'].$base_map;
}

require_once('config.inc.extra.php');

## -- cms versienummer
$cms['naam'] = 'BE.cms';
$cms['versie'] = '2.0';
$cms['codenaam'] = 'Fuujin';
$cms['contact'] = 'info@be-interactive.nl';

## -- nieuws
$nieuws_delen = true;

## -- directories inclusief trailing slash:
$upload_dir['base'] = $base_href;
$upload_dir['base_galerij'] = 'bestanden/fotos/';
$upload_dir['base_algemeen'] = 'bestanden/algemeen/';
$upload_dir['base_users'] = 'bestanden/users/';
$upload_dir['base_bijlagen'] = 'bestanden/bijlagen/';
$upload_dir['base_templates'] = 'bestanden/templates/';
$upload_dir['base_blog'] = 'bestanden/blog/';


## -- fck editor
$config_fck['UserFilesPath'] = 'http://'.$_SERVER['HTTP_HOST'].$base_map.'bestanden/fckeditor/';
$config_fck['UserFilesAbsolutePath'] = $_SERVER['DOCUMENT_ROOT'].$base_map.'bestanden/fckeditor/';


## -- metatags bedrijfsgegevens:
$cms_config['brute_force'] = 'bruteforce@be-interactive.nl';


## -- defenities:
require_once('define.inc.php');


## -- pagina types
$array_pagina_types = array(
	'algemeen' => 'Algemene Pagina\'s',
	'games' => 'Games',
);
	// permalinks voor htaccess
	$array_pagina_types_permalink = array(
		'algemeen' => '',
		'games' => 'games/',
	);


## -- admin stylesheet
$admin_css = 'fuujin';


## -- array gebruikersrechten
$priv_array = array(   
	1 => 'root',
	2 => 'admin',
	3 => 'user',
	4 => 'supportclub'
);
?>