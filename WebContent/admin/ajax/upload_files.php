<?php
header('Content-type: application/json');
require_once('../ajax_header.php');

$dir_db = $_POST['dir'];
$dir_upload = '../../'.$_POST['dir'];
$dir_show = '../'.$_POST['dir'];

$input = $_FILES['Filedata'];
$input['name_original'] = $input['name'];
$input['name'] = check_file($dir_upload, $input['name']);
//$input['name'] = set_file_name($input['name'], ''.date('U').'');

$array_status = array();
$array_status['upload_data'] = $input;
$array_status['file_id'] = md5($input['name'].date('YmdHis').rand(0,1979)); /* tijdelijke file_id */

$max_width = 800;
$max_height = 800;

$thumb_width = 220;
$thumb_height = 220;

if (is_uploaded_file($input['tmp_name'])) {
	$array_status['upload_status'] = true;
	
	// verplaats file naar de uploadmap
	if (move_uploaded_file($input['tmp_name'], $dir_upload.$input['name'])) {
		$array_status['upload_verplaatst'] = true;
		
		// insert file in dB
		$sql = "INSERT INTO `files` (file_id, check_id, check_type, naam, dir) 
		VALUES (NULL, '".$_POST['mijn_id']."', '".$_POST['tabelnaam']."', '".$input['name']."', '".$dir_db."')";
		$array_status['file_id'] = $db->insert_sql($sql);
		
		$sql_update = "UPDATE `files` SET `pos` = '".$file_id."' WHERE `file_id` = '".$file_id."' ";
		$db->update_sql($sql_update);
		
		// file inladen
		$img_icon = file_icon($input['name']);
		$array_status['file_preview'] = '
		<div class="file" id="x_'.$array_status['file_id'].'">
			<div class="item">'.$img_icon.$input['name'].'</div>
			<div class="handle"><img src="img/icons/up_16.png" alt="verplaatsen" class="bar" /><img src="img/icons/delete_16.png" alt="verwijderen" class="del" /></div>
		</div>
		';

		$array_status['upload_status'] = '<div>Bestand <em>'.$input['name_original'].'</em> is ge&uuml;pload.</div>';
		
	} else {
		$array_status['melding'] = '<div><strong>Fout:</strong> Kan bestand <em>'.$input['name'].'</em> niet verplaatsen naar de map  "upload/"</div>';
	}
	
} else {
	$array_status['upload_status'] = false;
	$array_status['melding'] = '<div><strong>Fout:</strong> Kan bestand <em>'.$input['name'].'</em> niet uploaden</div>';
}


## -- melding verwerken
if (!$array_status['melding']) {

} else {
	// eventuele rommel opruimen
	@unlink($dir.$input['name']);
	
	$sql_delete = "DELETE FROM `files` WHERE `file_id` = '".$array_status['file_id']."' ";
	$db->update_sql($sql_delete);
}

echo json_encode($array_status);  
exit();
?>