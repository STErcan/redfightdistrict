<?php
## -- start sessie
session_start();


## -- redirect
if (!$_GET['pagina']) {
	header('Location: index.php?pagina=home'); /* redirect naar home indien pagina != defined */
	exit();
}


## -- requirements
require_once("../class/db.class.php");
require_once("../includes/config.inc.php");
require_once("../includes/functies.inc.php");


## -- dB connectie maken
$db = new db($array_dbvars);


## -- header
header('Content-Type: text/html; charset=utf-8');


## -- inlog verwerking
if ($_POST['login_actie'] == 'go') {
	require_once('safe.login.php');
}


## -- safe sessie controle
require_once('safe.sessie.php');


## -- set site_id
if ($_GET['site_id']) {
	if (in_array($_GET['site_id'], $_SESSION['safe_'.$cms_config['token']]['sites'])) {
		$_SESSION['safe_'.$cms_config['token']]['site_id'] = $_GET['site_id'];
	} else {
		$_SESSION['safe_'.$cms_config['token']]['site_id'] = $_SESSION['safe_'.$cms_config['token']]['site_id'];
	}
}


## -- maak array van site_id's
$array_websites = maak_array('SELECT * FROM `sites` ORDER BY `positie`','site_id','site_naam');

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="'.$base_href.'admin/">
<title>CMS - BE interactive voor: '.$cms_config['bedrijf_naam'].' - v2.0</title>

<!-- default -->
<script language="javascript" type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="../js/fckeditor.js"></script>
<script language="javascript" type="text/javascript" src="js/functies_header.js"></script>
<script language="javascript" type="text/javascript" src="js/shortcuts.js"></script>

<!-- drag & drop -->
<script type="text/javascript" src="../js/jquery-ui-1.8.4.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.disable.select-text.js"></script>

<!-- fancybox -->
<script type="text/javascript" src="../js/jquery.fancybox-1.3.1.pack.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/jquery.pngFix.pack.js"></script>
<script type="text/javascript" src="../js/jquery.scrollTo-min.js"></script>
<style type="text/css" media="all">@import url("css/'.$admin_css.'/jquery.fancybox-1.3.1.css");</style>

<!-- spritely -->
<script type="text/javascript" src="../js/jquery.spritely-0.2.1.js"></script>

<!-- css -->
<style type="text/css" media="all">@import url("css/'.$admin_css.'/_main.css");</style>
<style type="text/css" media="all">@import url("css/'.$admin_css.'/jquery-ui-1.8rc3.custom.css");</style>
<style>
#map {
  font-family: Arial;
  font-size:12px;
  line-height:normal !important;
  height:250px;
  width:350px;
  background:transparent;
}
</style>



<!-- einde default -->

<!-- gmaps -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<!-- specifiek -->
<script language="javascript" type="text/javascript">
shortcut.add("Ctrl+S",function() {
	document.forms["form"].submit();
});
</script>
</head>
<body>
<div id="container">
	<div id="header">
		<div id="navigatie_top">
            <div id="ribbon">
				<span id="be_logo"></span>
				<span id="loading_sprite"></span>
			</div>
        	<ul>			
';
			// soort gebruiker
			if ($_SESSION['safe_'.$cms_config['token']]['priv']) {	
				$priv = $_SESSION['safe_'.$cms_config['token']]['priv'];
				echo '<li class="rechten">'.$_SESSION['safe_'.$cms_config['token']]['naam'].' ('.$priv_array[''.$priv.''].')</li>'."\n";
			}
echo '
            	<li><a href="?pagina=home" class="'.($_GET['pagina']=='home' ? 'actief'  : '').'">Home</a></li>
            	<li><a href="?pagina=loguit" class="'.($_GET['pagina']=='loguit' ? 'actief'  : '').'">Uitloggen</a></li>
            	<li><a href="'.$cms_config['website_url'].'" target="_blank" class="wit">Bezoek website</a></li>				
';
			// meerdere_websites
			if (count($array_websites)>1 && $_SESSION['safe_'.$cms_config['token']]['priv'] && count($_SESSION['safe_'.$cms_config['token']]['sites'])>1) {
				echo '<li class="sites"><span>&nbsp;<select name="select" onchange="if( this.value != 0 ) document.location.href=\'\'+this.value;" class="clean">'."\n";
				foreach ($array_websites as $key => $waarde) {
					// alleen de sites laten zien waar user recht op heeft
					if (in_array($key, $_SESSION['safe_'.$cms_config['token']]['sites'])) {
						echo '<option'.($_SESSION['safe_'.$cms_config['token']]['site_id'] == $key ? ' selected="selected"' : '').' value="?pagina=home&amp;site_id='.$key.'">site: '.$waarde.'</option>'."\n";
					}
				}
				echo '</select></span></li>'."\n";
			}
echo '
            </ul>
        </div>
	</div>
	<div id="body">
		<div id="navigatie_container">
			<div id="navigatie">
';
include('content_navigatie.php');
echo '
			</div>
		</div>
		<div id="content">
';
	## -- debugging ruimte ------------------------------------------------
	//pr('session');
	//pr($_SESSION);
	//pr('cookies');
	//pr($_COOKIE);
	## --------------------------------------------------------------------
	
		if ($_GET['pagina'] == 'home' || $_GET['pagina'] == 'login' || $_GET['pagina'] == 'loguit' || $_GET['pagina'] == 'ff') {
			require_once('content_'.$_GET['pagina'].'.php');
			
		} else if (file_exists('wijzig_'.$_GET['pagina'].'.php')) {
			if (!$_SESSION['safe_'.$cms_config['token']]['site_id']) {
				require_once('content_error.php');
			} else {
				require_once('wijzig_'.$_GET['pagina'].'.php');
			}
		} else {
			require_once('content_error.php');
		}
	
echo '
		</div>
		<div class="clear"></div>
	</div>

</div>
<div id="footer">
	<span id="versie">'.'U gebruikt <b>'.$cms['naam'].'</b> v'.$cms['versie'].' ['.$cms['codenaam'].']'.'</span>
	<!--<a href="?pagina=ff"><img src="img/get_firefox.gif" alt="get firefox" /></a>-->
</div>
';
require('js/functies_footer.php');
echo '
</body>
</html>
';
mysql_close(); 
?>