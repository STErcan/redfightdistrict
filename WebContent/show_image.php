<?php
//reference thumbnail class
include_once('includes/thumbnail.inc.php');

$thumb = new Thumbnail($_GET['img']);
$afmetingen = $thumb->afmetingen();

if ($afmetingen[0] < $_GET['breed'] && $afmetingen[1] < $_GET['hoog']) {
	//niks doen

} else {
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
}
if ($_GET['crop']) {
	$thumb->cropFromCenter($_GET['crop']);
}

$thumb->show(85);
$thumb->destruct();
exit;
?>