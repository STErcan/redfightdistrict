<?php
// array aanmaken voor uitzonderingen zonder meta_url
// array(tabelnaam, type, id)
$array_meta = array();
$array_meta['gastenboek']= array('paginas','18');

// set meta-url
if ($_GET['meta_url']) {
	$meta_url = sanitize($_GET['meta_url']);
}


// standaard waardes voor description en keywords
$description = $cms_config['meta_description'];
$keywords = $cms_config['meta_keywords'];

if (isset($array_meta[$_GET['pagina']])) {		
	$sql = "SELECT * FROM `".$array_meta[$_GET['pagina']][0]."` WHERE `pagina_id` = '".$array_meta[$_GET['pagina']][1]."' LIMIT 0,1";
} else {
	$sql = "SELECT * FROM `paginas` WHERE `meta_url` = '".$meta_url."' LIMIT 1";
}

if ($sql) {
	$result = $db->select($sql);
	$rows = $db->row_count;
	if ($rows == 1) {
		$array_meta = $db->get_row($result);
		$description = ($array_meta['meta_descr'] != '' ? $array_meta['meta_descr'] : $description);
		$keywords = ($array_meta['meta_key'] != '' ? $array_meta['meta_key'] : $keywords);
		$title = ($array_meta['titel'] != '' ? $array_meta['titel'] : $_GET['pagina']);
	}
}

echo '<title>'.$title.' | '.$cms_config['bedrijf_naam'].'</title>
<meta name="description" content="'.$description.'" />
<meta name="keywords" content="'.$keywords.'" />
';
?>