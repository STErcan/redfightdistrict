<?php
## -- Laat modules zien
$add_delete = true;


## -- instellingen en paden
$tabelnaam = 'configuratie';
$module_naam = 'configuratie';
$prefix = 'config_';
$item_pre = 'de';
$item_titel = 'configuratie';
$pagina_main_titel = 'Configuratie';

$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
$foutmelding_wijzig = 'Kan '.$item_titel.' niet wijzigen.';


## -- privileges (1 = admin, 2 = poweruser, 3 = user)
$privileges = priv(array(1));


// javascript
$eerste_tab = 'omschrijving';
$tree_diepte = 'omschrijving';
?>