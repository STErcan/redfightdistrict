<?php
header('Content-type: application/json');
require_once('../ajax_header.php');

$dir_db = $_POST['dir'];
$dir_upload = '../../'.$_POST['dir'];
$dir_show = '../'.$_POST['dir'];

$input = $_FILES['Filedata'];
$input['name_original'] = $input['name'];
$input['name'] = sanitize_file_name($input['name']);
$input['name'] = set_file_name($input['name'], ''.date('U').'');

$array_status = array();
$array_status['upload_data'] = $input;
$array_status['file_id'] = md5($input['name'].date('YmdHis').rand(0,1979)); /* tijdelijke file_id */

$max_width = 800;
$max_height = 800;

$thumb_width = 130;
$thumb_height = 73;

if (is_uploaded_file($input['tmp_name'])) {
	$array_status['upload_status'] = true;
	
	// verplaats file naar de uploadmap
	if (move_uploaded_file($input['tmp_name'], $dir_upload.$input['name'])) {
		$array_status['upload_verplaatst'] = true;
		
		// orgineel verkleinen
		$resize['img'] = $dir_upload.$input['name'].'';
		$resize['width'] = $max_width;
		$resize['height'] = $max_height;
		$resize['crop'] = false;
		$resize['save'] = 1;
		$resize['quality'] = 95;
		require('../resize_image.php');
		
		// maak kopie als thumb
		$thumb_name = set_file_name($input['name']);
		if (copy($dir_upload.$input['name'], $dir_upload.$thumb_name)) {
			$array_status['thumb_verplaatst'] = true;
	
			// thumbnail verkleinen
			$resize['img'] = $dir_upload.$thumb_name.'';
			$resize['width'] = $thumb_width;
			$resize['height'] = $thumb_height;
			$resize['crop_adaptive'] = array($thumb_width,$thumb_height);
			$resize['save'] = 1;
			$resize['quality'] = 85;
			require('../resize_image.php');
			
			// insert file in dB
			$sql = "INSERT INTO `files` (file_id, check_id, check_type, naam, dir) 
			VALUES (NULL, '".$_POST['mijn_id']."', '".$_POST['tabelnaam']."_galerij', '".$input['name']."', '".$dir_db."')";
			$array_status['file_id'] = $db->insert_sql($sql);
			
			$sql_update = "UPDATE `files` SET `pos` = '".$file_id."' WHERE `file_id` = '".$file_id."' ";
			$db->update_sql($sql_update);
			
			// thumbnail inladen
			$array_status['img_preview'] = '
			<div class="thumb" id="x_'.$array_status['file_id'].'">
				<div class="handle"><img src="img/icons/back_16.png" alt="verplaatsen" class="bar" /><img src="img/icons/delete_16.png" alt="verwijderen" class="del" /></div>
				<a rel="galerij" href="'.$dir_show.$input['name'].'" class="fancy img">
					<img src="show_image_admin.php?img='.$dir_show.$thumb_name.'&amp;crop=110" style="opacity:0;" rel="'.$array_status['file_id'].'" class="thumbnail" />
				</a>
				<div class="descr"><span id="span_'.$array_status['file_id'].'" onClick="edit_descr(\''.$array_status['file_id'].'\');"></span><textarea id="descr_'.$array_status['file_id'].'" style="display:none;"></textarea></div>
			</div>
			';
			$array_status['upload_status'] = '<div>Afbeelding <em>'.$input['name_original'].'</em> is ge&uuml;pload.</div>';
		} else {
			$array_status['melding'] = '<div><strong>Fout:</strong> Kan afbeelding <em>'.$input['name'].'</em> niet kopieren als thumbnail.</div>';
		}
		
	} else {
		$array_status['melding'] = '<div><strong>Fout:</strong> Kan afbeelding <em>'.$input['name'].'</em> niet verplaatsen naar de map  "upload/"</div>';
	}
	
} else {
	$array_status['upload_status'] = false;
	$array_status['melding'] = '<div><strong>Fout:</strong> Kan afbeelding <em>'.$input['name'].'</em> niet uploaden</div>';
}


## -- melding verwerken
if (!$array_status['melding']) {

} else {
	// eventuele rommel opruimen
	@unlink($dir.$input['name']);
	@unlink($dir.$thumb_name);
	
	$sql_delete = "DELETE FROM `files` WHERE `file_id` = '".$array_status['file_id']."' ";
	$db->update_sql($sql_delete);
}

echo json_encode($array_status);  
exit();
?>