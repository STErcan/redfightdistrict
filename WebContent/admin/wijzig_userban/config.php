<?php
## -- Laat modules zien
$add_delete = true;


## -- instellingen en paden
$tabelnaam = 'userban';
$module_naam = 'userban';
$prefix = '';
$item_pre = 'de';
$item_titel = 'blokkade';
$pagina_main_titel = 'IP blokkade (bruteforce)';
$melding_x = '';
if ($_GET['tab'] == 'geschiedenis') {
	$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
	$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
} else {
	$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' opgeheven mag worden?';
	$foutmelding_verwijder = 'Kan '.$item_titel.' niet opheffen.';
}


## -- privileges (1 = admin, 2 = poweruser, 3 = user)
$privileges = priv(array(1));


## -- javascript
$eerste_tab = 'geblokkeerd';
?>