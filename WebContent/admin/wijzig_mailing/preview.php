<?php
// requirements
require_once('../ajax_header.php');
require_once('config.php');

$sql = "SELECT * FROM `".$tabelnaam."` WHERE `".$prefix."id` = '".$_GET['id']."' LIMIT 0,1";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows == 1)  {
	$info = $db->get_row($result);
	$array_items = explode(',',$info['items']);
	$array_items = array_filter($array_items);
}


// intro tekst
$datum = date('d-m-Y');
$intro['html'] = sprintf($intro_html,'Test Gebruiker',$datum);
$intro['txt'] = sprintf($intro_txt,'Test Gebruiker',$datum);

// afmeld link
$sha_key = sha1($email_adres.'+'.$email_id);
$afmeld_url_def = sprintf($afmeld_url,urlencode($email_adres),urlencode($sha_key));
$afmelden['html'] = sprintf($afmelden_html,$afmeld_url_def,$afmeld_url_def);
$afmelden['txt'] = sprintf($afmelden_txt,$afmeld_url_def);

// extra inhoud (items)
$array_items = array_filter($array_items);

if (count($array_items)>0) {
	$content_items['txt'] = "\n";
	$content_items['html'] = '';
	foreach ($array_items as $key => $waarde) {
		$sql_items = "
		SELECT * FROM `paginas` 
		LEFT JOIN `files` ON ((`files`.`check_id` = `paginas`.`pagina_id`) && (`files`.`check_type` LIKE '%nieuws_foto_2%'))
		WHERE `paginas`.`pagina_id` = '".$waarde."' LIMIT 0,1
		";
		$result_items = $db->select($sql_items);
		$rows_items = $db->row_count;
		if ($rows_items == 1)  {
			$nieuws_item = $db->get_row($result_items);
		
			$afbeelding = ($nieuws_item['naam'] ? $upload_dir['base'].$nieuws_item['dir'].$nieuws_item['naam'] : $upload_dir['base'].'img/pixel.gif');
			$content_items['txt'] .= sprintf($item_txt, $nieuws_item['titel'], inkorten($nieuws_item['tekst'],250), $upload_dir['base'].'nieuwsbrief.php?item_id='.$nieuws_item['pagina_id']);
			$content_items['html'] .= sprintf($item_html, $afbeelding, $nieuws_item['titel'], inkorten($nieuws_item['tekst'],250), $upload_dir['base'].'nieuwsbrief.php?item_id='.$nieuws_item['pagina_id']);
		}
	}
}


if ($_GET['type'] == 'txt') {
	
	$template = $intro['txt'];
	$template .= $info['tekst_txt'];
	$template .= $content_items['txt'];
	$template .= $afmelden['txt'];
	
	echo '<pre style="white-space:pre-wrap;">'.$template.'</pre>';
}
if ($_GET['type'] == 'html') {
	$template = file_get_contents('../../'.$upload_dir['base_templates'].$array_templates[$info['template']]);
	$template = str_replace('@@INTRO@@',$intro['html'],$template);
	$template = str_replace('@@CONTENT@@',$info['tekst_html'],$template);
	$template = str_replace('@@CONTENT_ITEMS@@',$content_items['html'],$template);
	$template = str_replace('@@AFMELDEN@@',$afmelden['html'],$template);

	echo $template;
}
?>