<?php
require_once('../ajax_header.php');
require_once('config.php');

## fotoconfig laden
if ($_POST['check_type'] == 'paginas') {
	# wijzig_paginas
	include('../wijzig_paginas/config.foto.php');
	$settings = $array_fotos_types[$_POST['pagina_type']][$_POST['array_key']];
} else {
	include('../wijzig_'.$_POST['check_type'].'/config.foto.php');
	$settings = $array_fotos[$_POST['array_key']];
}

## minimale afmetingen overschrijven
$geen_crop = (isset($settings['geen_crop']) ? $settings['geen_crop'] : $geen_crop);
$min_w = (isset($settings['min_w']) ? $settings['min_w'] : $min_w);
$min_h = (isset($settings['min_h']) ? $settings['min_h'] : $min_h);
if (isset($settings['ratio']) && !$settings['ratio']) {
	$ratio = false;
} else if (isset($settings['ratio']) && $settings['ratio']) {
	$ratio = true;
} else {
	$ratio = $ratio;
}
if (isset($settings['cropsize']) && !$settings['cropsize']) {
	$cropsize = false;
} else if (isset($settings['cropsize']) && $settings['cropsize']) {
	$cropsize = true;
} else {
	$cropsize = $cropsize;
}
if (count($settings['thumbs'])>0){
	if ($settings['thumbs'] == false) {
		$thumbnail = false;
	} else {
		$thumbnail = true;
	}
}

## no crop / resize
if ($settings['geen_crop']==1) {
	copy($dir.$dir_upload.$_POST['f'], $dir.$dir_crop.$_POST['f']);
} else {
	copy($dir.$dir_upload.$_POST['f'], $dir.$dir_crop.$_POST['f']);

	$resize = array();
	if ($settings['resize_marge']==true) {
		$resize['crop_array'] = array($_POST['x'],$_POST['y'],($_POST['w']+1),($_POST['h']+1));
	} else {
		$resize['crop_array'] = array($_POST['x'],$_POST['y'],$_POST['w'],$_POST['h']);
	}
	
	// geen resize
	if ($settings['cropsize']==true) {
		$resize['crop_adaptive'] = array($settings['min_w'], $settings['min_h']);
		
	}

	// resize naar thumbgrootte
	$resize['img'] = $dir.$dir_crop.$_POST['f'];
	$resize['save'] = 1;
	$resize['quality'] = 100;
	require('../resize_image.php');
	
}


## create thumbs
if ($thumbnail) {
	if (count($settings['thumbs'])>0){
		$thumbnails = '<strong>Thumbnail(s):</strong><br>';
		
		foreach ($settings['thumbs'] as $key => $value) {
			$thumb_naam = set_file_name($_POST['f'], $value['thumb_ext']);
			copy($dir.$dir_crop.$_POST['f'], $dir.$dir_crop.$thumb_naam);

			// crop/resize settings
			$resize = array();
			if ($value['thumb_crop']) {
				$resize['crop_adaptive'] = array($value['thumb_crop'][0],$value['thumb_crop'][1]);
			} else {
				$resize['width'] = $value['thumb_size'][0];
				$resize['height'] = $value['thumb_size'][1];
			}
			
			// resize naar thumbgrootte
			$resize['img'] = $dir.$dir_crop.$thumb_naam;
			$resize['save'] = 1;
			$resize['quality'] = 90;
			require('../resize_image.php');
			
			$thumbnails .= '<div class="thumbnail_preview"><img src="'.$dir.$dir_crop.$thumb_naam.'?rand='.microtime().'" /><span>'.$value['descr'].'</span></div>';
		}
		echo $thumbnails;
	}
}
?>