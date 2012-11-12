<?php
## -- Laat modules zien
$add_delete = true;


## -- instellingen en paden
$tabelnaam = 'mailing_lijsten';
$module_naam = 'mailing_lijsten';
$item_pre = 'de';
$prefix = 'lijst_';
$item_titel = 'lijst';
$pagina_main_titel = 'Mailing lijsten';

$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
$foutmelding_wijzig = 'Kan '.$item_titel.' niet wijzigen.';


## -- privileges (1 = admin, 2 = poweruser, 3 = user)
$privileges = priv(array(1,2,3));


## -- javascript
$eerste_tab = 'omschrijving';
?>