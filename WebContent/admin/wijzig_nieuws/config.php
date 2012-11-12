<?php
## -- Laat modules zien
$add_delete = true;
$add_bijlagen = true;
$add_foto = true;
$add_galerij = false;
$zichtbaarheid = true;
$nieuws_delen = false;



## -- crop foto's en instellingen 
include('config.foto.php');


## -- instellingen en paden
$dir = $upload_dir['base_algemeen'];
$dir_galerij = $upload_dir['base_galerij'];
$dir_bijlagen = $upload_dir['base_bijlagen'];
$tabelnaam = 'paginas';
$module_naam = 'nieuws';
$prefix = 'pagina_';
$item_pre = 'het';
$item_titel = 'nieuwsbericht';
$pagina_main_titel = 'Nieuwsberichten';
$limiet_overzicht = 15;
$permalink = 'nieuws/';

$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
$foutmelding_wijzig = 'Kan '.$item_titel.' niet wijzigen.';



## -- privileges (1 = admin, 2 = poweruser, 3 = user)
$privileges = priv(array(1,2,3));



## -- javascript
$eerste_tab = 'omschrijving';
?>