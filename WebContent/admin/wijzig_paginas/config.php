<?php
## -- Laat modules zien
$add_bijlagen = false;
$add_delete = true;
$add_foto = true;
$add_galerij = true;
$add_youtube = false;

$edit_meta_url = ($_SESSION['safe_'.$cms_config['token']]['priv']==1 ? true : false);
		
switch ($_GET['type']) {
	case 'algemeen':
		$add_foto = true;
		break;
}

include('config.foto.php');


## -- paden
$dir = $upload_dir['base_algemeen'];
$dir_galerij = $upload_dir['base_galerij'];
$dir_bijlagen = $upload_dir['base_bijlagen'];

## -- standaard instellingen / omschrijvingen
$tabelnaam = 'paginas';
$module_naam = 'paginas';
$prefix = 'pagina_';
$item_pre = 'de';
$item_pre_nieuw = 'nieuwe';
$item_titel = 'pagina';
$pagina_main_titel = $array_pagina_types[$_GET['type']];

$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
$foutmelding_wijzig = 'Kan '.$item_titel.' niet wijzigen.';


## -- formulier per type
// elk type pagina kan een eigen omschrijving-tab hebben
$form_omschrijving_types = array(
	'algemeen' => 'omschrijving',
	'games' => 'omschrijving_games',
);
$form_omschrijving = $form_omschrijving_types[$_GET['type']];


## -- datavelden per type
// dit zijn extra database velden die via de omschrijving-tab gebruikt moeten worden
$array_datavelden_types = array(
	'events' => array(
		'adr_descr',
		'adr_straat',
		'adr_postcode',
		'adr_plaats',
		'tijd',
		'locatie',
		'entree',
		'leeftijd',
		'lineup',
	),
	'partypics' => array(),
);


## -- privileges (1 = admin, 2 = poweruser, 3 = user)
if ($_GET['type'] == 'supportclub') {
	$privileges = priv(array(1,2,3,4));
} else {
	$privileges = priv(array(1,2,3));
}


## -- pagina types met categorien
// array van paginatypes die gebruik maken van de categorien-module
$array_parents = array();


## -- javascript
$eerste_tab = $form_omschrijving;
?>