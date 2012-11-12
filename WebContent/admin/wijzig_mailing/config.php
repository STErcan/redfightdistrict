<?php
## -- Laat modules zien
$add_delete = true;


## -- instellingen en paden
$tabelnaam = 'mailing';
$module_naam = 'mailing';
$prefix = 'pagina_';
$item_pre = 'de';
$item_pre_nieuw = 'nieuwe';
$item_titel = 'nieuwsbrief';
$pagina_main_titel = 'Nieuwsbrieven';
$limiet_overzicht = 20;

$melding_verwijder = 'Weet u zeker dat '.$item_pre.' '.$item_titel.' verwijderd mag worden?';
$foutmelding_verwijder = 'Kan '.$item_titel.' niet verwijderen.';
$foutmelding_wijzig = 'Kan '.$item_titel.' niet wijzigen.';


## -- privileges (1 = admin, 2 = poweruser, 3 = user)
$privileges = priv(array(1,2,3));


## -- javascript
$eerste_tab = 'overzicht_nieuw';


## -- nieuwsbrief templates
$array_templates = array(
	'normaal' => 'normaal.htm',
	'fancy' => 'fancy.htm',
);


## -- nieuwsbrief content
$afmeld_url = $upload_dir['base'].'nieuwsbrief-instelling/%s/%s.htm';

$intro_html = 'Beste %s,<br /> Dit is de nieuwsbrief van <a href="'.$cms_config['website_url'].'" style="color:#fff;">'.$cms_config['bedrijf_naam'].'</a>, <br />datum: %s';
$intro_txt = "\nBeste %s,\nDit is de nieuwsbrief van ".$cms_config['bedrijf_naam'].", datum: %s\n\n\n";

$afmelden_html = '<a href="%s" style="color:#fff;">klik hier</a> om je nieuwsbrief instellingen te wijzigen';
$afmelden_txt = "\nKlik op deze link om je nieuwsbrief instellingen te wijzigen: \n%s";

$item_html = '
	<p><img src="%s" width="100" align="left" border="1" style="border:1px solid #ccc; float:left; margin:0 1em 0 0;" />
	<b style="font-size:14px;">%s</b><br />%s <a href="%s">Lees verder &raquo;</a></p>
	<div style="clear:both;"><br /></div>
';
$item_txt = "\n%s\n%s lees verder op: %s\n";

?>