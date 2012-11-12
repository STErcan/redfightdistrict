<?php
## init thumbnail
require_once('../../includes/thumbclass/ThumbLib.inc.php');
$thumb = PhpThumbFactory::create($resize['img']);

## get current dimensions
$thumb_dimensions_cur = $thumb->getCurrentDimensions();

## resize image
	
	// adaptive crop
	if ($resize['crop']) {
		if ($thumb_dimensions_cur['width']>$resize['crop'] || $thumb_dimensions_cur['height']>$resize['crop']) {
			$thumb->adaptiveResize($resize['crop'],$resize['crop']);
			## get new dimensions
			$thumb_dimensions_new = $thumb->getNewDimensions();
		} else {
			$thumb_dimensions_new = array('newWidth'=>$thumb_dimensions_cur['width'], 'newHeight'=>$thumb_dimensions_cur['height']);
		}
		$thumb_dimensions = array_merge($thumb_dimensions_cur, $thumb_dimensions_new);
	
	// crop then resize
	} else if ($resize['crop_array'] && $resize['crop_adaptive']) {
		$thumb->crop($resize['crop_array'][0],$resize['crop_array'][1],$resize['crop_array'][2],$resize['crop_array'][3]);
		$thumb->adaptiveResize($resize['crop_adaptive'][0],$resize['crop_adaptive'][1]);
	
	// adaptive crop (not evenly square)
	} else if ($resize['crop_adaptive']) {
		$thumb->adaptiveResize($resize['crop_adaptive'][0],$resize['crop_adaptive'][1]);
	
	// pure crop
	} else if ($resize['crop_array']) {
		$thumb->crop($resize['crop_array'][0],$resize['crop_array'][1],$resize['crop_array'][2],$resize['crop_array'][3]);
	
	// resize
	} else {
		if ($thumb_dimensions_cur['width']>$resize['width'] || $thumb_dimensions_cur['height']>$resize['height']) {
			$thumb->resize($resize['width'],$resize['height']); /* only resize when necessary */
			## get new dimensions
			$thumb_dimensions_new = $thumb->getNewDimensions();
		} else {
			$thumb_dimensions_new = array('newWidth'=>$thumb_dimensions_cur['width'], 'newHeight'=>$thumb_dimensions_cur['height']);
		}
		$thumb_dimensions = array_merge($thumb_dimensions_cur, $thumb_dimensions_new);
	}


## set quality
if ($resize['quality']) {
	$quality = $resize['quality'];
} else {
	$quality = 100;
}
$thumb->setOptions(array('jpegQuality' => $quality));

## save / show
if ($resize['save']==1) {
	$thumb->save($resize['img']);
} else {
	$thumb->show();
}
?>