<?php
require_once('../ajax_header.php');
require_once('config.php');

$resize_succes = false;
$error_msg = false;


if ($_FILES['file_up']) {

	// extentie toegestaan?
	if (!in_array(strtolower(extention($_FILES['file_up']['name'])), $array_ext)) {
		// nee gooi foutmelding erin
		$error_msg = 'Uw afbeelding heeft een ongeldige bestandsformaat: &raquo; <b>'.extentie($_FILES['file_up']['name']).'</b> &laquo;<br />De toegestane extenties zijn: <b>'.implode(', ',$array_ext).'</b>';
	
	} else {
		pr($_POST);
		// fotoconfig laden
		if ($_POST['check_type'] == 'paginas') {
			# wijzig_paginas
			include('../wijzig_paginas/config.foto.php');
			$settings = $array_fotos_types[$_POST['pagina_type']][$_POST['array_key']];
		} else {
			include('../wijzig_'.$_POST['check_type'].'/config.foto.php');
			$settings = $array_fotos[$_POST['array_key']];
		}
		pr($settings);
	
		// bestand uploaden en verkleinen
		$input = $_FILES['file_up'];
		$input['name'] = set_file_name($input['name'], ''.date('U').'');
		
		$array_status = array();
		$array_status['upload_data'] = $input;
		$array_status['file_id'] = md5($input['name'].date('YmdHis').rand(0,1979)); /* tijdelijke file_id */
			
		if (is_uploaded_file($input['tmp_name'])) {
			$array_status['upload_status'] = true;
			
			// verplaats file naar de uploadmap
			if (move_uploaded_file($input['tmp_name'], $dir.$dir_upload.$input['name'])) {
				$array_status['upload_verplaatst'] = true;
	
				// orgineel verkleinen
				$resize['img'] = $dir.$dir_upload.$input['name'].'';
				$resize['width'] = $max_width;
				$resize['height'] = $max_height;
				$resize['crop'] = false;
				$resize['save'] = 1;
				$resize['quality'] = 95;
				require('../resize_image.php');
				
				pr($thumb_dimensions);
			
			} else {
				$array_status['melding'] = '<div><strong>Fout:</strong> Kan afbeelding <em>'.$input['name'].'</em> niet verplaatsen naar de map  "upload/"</div>';
			}
			
		} else {
			$array_status['upload_status'] = false;
			$array_status['melding'] = '<div><strong>Fout:</strong> Kan afbeelding <em>'.$input['name'].'</em> niet uploaden</div>';
		}
		
		
		// controleer afmetingen			
		if ($thumb_dimensions['width']<$min_width || $thumb_dimensions['height']<$min_height) {
			// te kleine afbeelding
			$error_msg = 'Uw afbeelding is te klein:<br />breedte: '.$thumb_dimensions['width'].' <br />hoogte: '.$thumb_dimensions['height'].'<br /><br />De minimale afmetingen zijn:<br />breedte: '.$min_width.' <br />hoogte: '.$min_height.'<br /><br /><b>Graag een andere afbeelding uploaden</b>';
		} else {
			
			// te kleine afbeelding NA verkleining
			if ($thumb_dimensions['newWidth']<$min_width || $thumb_dimensions['newHeight']<$min_height) {
				$error_msg = 'Uw afbeelding heeft na de automatische verkleining niet de juiste verhouding:<br />breedte: '.$thumb_dimensions['newWidth'].' <br />hoogte: '.$thumb_dimensions['newHeight'].'<br /><br />De minimale afmetingen zijn:<br />breedte: '.$min_width.' <br />hoogte: '.$min_height.'<br /><br /><b>Graag een andere afbeelding uploaden met betere hoogte/breedte verhouding!</b>';
			
			} else {
				$resize_succes = true;
				
				// set juiste afmetingen
				if ($width_check<$width) {
					$width_def = $width_check;
					$height_def = $height_check;
				} else {
					$width_def = $width;
					$height_def = $height;
				}
				
			}
		}
			
	}

	echo '<pre>';
	echo $min_width.'-';
	echo $min_height;
	echo '</pre>';

	if ($error_msg) {
		echo '
		<script language="javascript">
			window.parent.error("'.$error_msg.'");
		</script>
		';
	} else {
		if ($resize_succes == true) {
?>
	<script language="javascript">
		window.onload = function() {
			<?php
			if ($_POST['geen_crop']==1) {
				echo "
				window.parent.set_crop_vars(".$thumb_dimensions['newWidth'].",".$thumb_dimensions['newHeight'].");
				window.parent.setCoords(".$thumb_dimensions['newWidth'].",".$thumb_dimensions['newHeight'].");
				
				parent.document.getElementById('cropbox_container').innerHTML = '<img src=\'".$dir.$dir_upload.$input['name']."\' id=\'cropbox\' />';
				parent.document.getElementById('cropbox_container').style.width = '".($thumb_dimensions['newWidth'])."px"."';
				parent.document.getElementById('preview_container').innerHTML = '<img src=\'".$dir.$dir_upload.$input['name']."\' id=\'preview\' />';
				parent.document.getElementById('f').value = '".$input['name']."';
				parent.document.getElementById('file_up').value = '';
				parent.document.getElementById('ready_container_img').innerHTML = '';
				window.parent.submit_crop();
				";
			} else {
				echo "
				window.parent.set_crop_vars(".$thumb_dimensions['newWidth'].",".$thumb_dimensions['newHeight'].");
				
				parent.document.getElementById('cropbox_container').innerHTML = '<img src=\'".$dir.$dir_upload.$input['name']."\' id=\'cropbox\' />';
				parent.document.getElementById('cropbox_container').style.width = '".($thumb_dimensions['newWidth'])."px"."';
				parent.document.getElementById('preview_container').innerHTML = '<img src=\'".$dir.$dir_upload.$input['name']."\' id=\'preview\' />';
				parent.document.getElementById('f').value = '".$input['name']."';
				parent.document.getElementById('file_up').value = '';
				parent.document.getElementById('ready_container_img').innerHTML = '';
				
				window.parent.show_geen_crop();
				window.parent.init_cropper();
				";
			}
			?>


		}
	</script>
<?php
		}
	
	}

	
}
?>
