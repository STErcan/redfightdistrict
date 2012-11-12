<?php
## init thumbnail
require_once('../includes/thumbclass/ThumbLib.inc.php');
$thumb = PhpThumbFactory::create($_GET['img']);

## crop or resize?
if ($_GET['crop']) {
	$thumb->adaptiveResize($_GET['crop'],$_GET['crop']);
} else if ($_GET['width']>0 && $_GET['height']>0) {
	$thumb->resize($_GET['width'],$_GET['height']);
}

## set quality
if ($_GET['quality']) {
	$quality = $_GET['quality'];
} else {
	$quality = 100;
}
$thumb->setOptions(array('jpegQuality' => $quality));

## save / show
if ($_GET['save']==1) {
	$thumb->save($_GET['img']);
} else {
	$thumb->show();
}
exit();
?>