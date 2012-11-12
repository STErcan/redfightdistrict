<?php
## -- Laat modules zien
$add_delete = true;



## -- instellingen en paden
$tabelnaam = 'reacties';
$module_naam = 'reacties';
$prefix = 'reactie_';
$item_pre = 'de';
$item_titel = 'reactie';
$item_titel_mv = 'reacties';
$pagina_main_titel = 'Reacties';
$limiet_overzicht = 20;
$default_type = 'reacties';

$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
$foutmelding_wijzig = 'Kan '.$item_titel.' niet wijzigen.';



## -- privileges (1 = admin, 2 = poweruser, 3 = user)
$privileges = priv(array(1,2,3));



## -- javascript
$eerste_tab = 'overzicht_nieuw';
?>