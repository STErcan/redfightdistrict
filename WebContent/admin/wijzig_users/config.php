<?php
## -- Laat modules zien
$add_delete = true;


## -- instellingen en paden
$dir = $upload_dir['base_users'];
$dir_galerij = $upload_dir['base_galerij'];
$dir_bijlagen = $upload_dir['base_bijlagen'];
$tabelnaam = 'users';
$module_naam = 'users';
$prefix = 'user_';
$item_pre = 'de';
$item_titel = 'user';
$pagina_main_titel = 'Users';

$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
$foutmelding_wijzig = 'Kan '.$item_titel.' niet wijzigen.';


## -- privileges (1 = admin, 2 = poweruser, 3 = user)
$privileges = priv(array(1,2));


// javascript
$eerste_tab = 'omschrijving';
?>