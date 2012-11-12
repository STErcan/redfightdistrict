<?php
header('Content-type: application/json');
require_once('../ajax_header.php');

$vcode = $_POST['vcode'];

if ($vcode) {	
## -- make array voor meta veld:
$title = $_POST['title'];
$published = $_POST['published'];
$uploader = $_POST['uploader'];
$meta = '{"title": "'.$title.'", "published": "'.$published.'","uploader": "'.$uploader.'"}';

	// insert file in dB
	$sql = "INSERT INTO `files` (file_id, check_id, check_type, naam, dir, meta) 
	VALUES (NULL, '".$_POST['mijn_id']."', '".$_POST['tabelnaam']."_youtube', '".$vcode."', '','".$meta."')";
	$array_status['file_id'] = $db->insert_sql($sql);
	
	$sql_update = "UPDATE `files` SET `pos` = '".$file_id."' WHERE `file_id` = '".$file_id."' ";
	$db->update_sql($sql_update);
	
	// thumbnail inladen
	$array_status['img_preview'] = '
	<div class="thumb_yt" id="x_'.$array_status['file_id'].'">
		<div class="handle"><img src="img/icons/back_16.png" alt="verplaatsen" class="bar" /><img src="img/icons/delete_16.png" alt="verwijderen" class="del" /></div>
			<embed class="yt" src="http://www.youtube.com/v/'.$vcode.'?fs=1&amp;hl=nl_NL&amp;rel=0" type="application/x-shockwave-flash" scale="scale" wmode="transparent"></embed>
		<div class="descr"><span>'.$title.'</span></div>
	</div>
	';
	$array_status['upload_status'] = '<div>Video <em>'.$vcode.'</em> is toegevoegd.</div>';
	
} else {
	$array_status['upload_status'] = false;
	$array_status['melding'] = '<div><strong>Fout:</strong> Kan video <em>'.$input['name'].'</em> niet toevoegen</div>';
}



echo json_encode($array_status);  
exit();
?>