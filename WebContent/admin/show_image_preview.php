<?php
// Work around the Flash Player Cookie Bug
if (isset($_POST['PHPSESSID'])) {
	session_id($_POST['PHPSESSID']);
}
session_start();

if (isset($_GET['id'])) {
	
	if (!is_array($_SESSION['file_upload']) || !isset($_SESSION['file_upload'][$_GET['id']])) {
		header('HTTP/1.1 404 Not found');
		exit(0);
	} else {
		$image_file = $_SESSION['file_upload'][$_GET['id']]['normaal'];
	}
}

if (isset($_GET['img'])) {
	$image_file = $_GET['img'];
}

if (!$image_file) {
	header('HTTP/1.1 500 Internal Server Error');
	echo 'Geen ID of Locatie';
	exit(0);
}


//reference thumbnail class
include_once('../includes/thumbnail.inc.php');

$thumb = new Thumbnail($image_file);
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
$thumb->resize($breedte,$hoogte);

if ($_GET['crop']) {
	$thumb->cropFromCenter($_GET['crop']);
}
$thumb->show(95);
$thumb->destruct();
exit();
?>