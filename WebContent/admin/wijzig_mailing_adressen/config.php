<?php
## -- Laat modules zien
$add_delete = true;


## -- instellingen en paden
$tabelnaam = 'mailing_adressen';
$module_naam = 'mailing_adressen';
$prefix = 'email_';
$item_pre = 'de';
$item_titel = 'abonnee';
$pagina_main_titel = 'Abonnees';

$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
$foutmelding_wijzig = 'Kan '.$item_titel.' niet wijzigen.';

$limiet_overzicht = 100;

$status_array = array(
	0 => 'actief',
	1 => 'afgemeld',
);

## -- privileges (1 = admin, 2 = poweruser, 3 = user)
$privileges = priv(array(1,2,3));


// javascript
$eerste_tab = 'overzicht_zoeken';
?>