<?php
// Work around the Flash Player Cookie Bug
if (isset($_POST['PHPSESSID'])) {
	session_id($_POST['PHPSESSID']);
}
session_start();

$image_id = isset($_GET['id']) ? $_GET['id'] : false;

if ($image_id === false) {
	header('HTTP/1.1 500 Internal Server Error');
	echo 'No ID';
	exit(0);
}
if (!is_array($_SESSION['file_upload']) || !isset($_SESSION['file_upload'][$image_id])) {
	header('HTTP/1.1 404 Not found');
	exit(0);
}

//reference thumbnail class
include_once('../includes/thumbnail.inc.php');


// check of er een thumb gemaakt moet worden
if ($_GET['thumb'] == 1) {
	$file = $_SESSION['file_upload'][$image_id]['thumb'];
} else {
	$file = $_SESSION['file_upload'][$image_id]['normaal'];
}

$thumb = new Thumbnail($file);
$afmetingen = $thumb->afmetingen();

// minimale afmetingen afvangen
if ($_GET['min'] == 1) {
	if ($afmetingen[0] >= $afmetingen[1]) {
		//liggende afbeelding
		$hoogte_factor = @round(($_GET['hoog']/$afmetingen[1]),5);
		$hoogte = @round($afmetingen[1]*$hoogte_factor);
		$breedte = @round($afmetingen[0]*$hoogte_factor);
	} else {
		//staande afbeelding
		$breedte_factor = @round(($_GET['hoog']/$afmetingen[0]),5);
		$breedte = @round($afmetingen[0]*$breedte_factor);
		$hoogte = @round($afmetingen[1]*$breedte_factor);
	}
} else {
	$breedte = $_GET['breed'];
	$hoogte = $_GET['hoog'];
}


// check of er een thumb gemaakt moet worden
if ($_GET['thumb'] == 1) {
	include_once('../includes/config.inc.images.php');
	
	// module
	if ($thumbs_config['pagina'][$_GET['pagina']]) {
		$breedte = $thumbs_config['pagina'][$_GET['pagina']][0];
		$hoogte = $thumbs_config['pagina'][$_GET['pagina']][1];
	// pagina type
	} else if ($thumbs_config['pagina_type'][$_GET['type']]) {
		$breedte = $thumbs_config['pagina_type'][$_GET['type']][0];
		$hoogte = $thumbs_config['pagina_type'][$_GET['type']][1];
	// default
	} else {
		$breedte = $thumbs_config['default'][0];
		$hoogte = $thumbs_config['default'][1];
	}
}


if ($afmetingen[0]<=$breedte && $afmetingen[1]<=$hoogte) {
	// niet verkleinen
} else {
	$thumb->resize($breedte,$hoogte);
}


if ($_GET['crop']) {
	$thumb->cropFromCenter($_GET['crop']);
}

$thumb->save($file,100);
$thumb->destruct();

exit();
?>