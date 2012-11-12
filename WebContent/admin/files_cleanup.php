<?php
##########################################
// Even wat dingen instellen.
$dirname= "../bestanden/fotos/";// directory met plaatjes ten opzichte van de huidige directory
$img_extensions = array('jpg', 'JPG', 'gif', 'GIF');// de toegestane plaatjes
##########################################

function check_file_galerij($filename){
    global $img_extensions;
    $file_array = explode('.', $filename);
    return (in_array(strtolower($file_array[count($file_array)-1]), $img_extensions));
}


function get_file_array($dir){
    $file_array = array();
    if($handle = opendir($dir)) {
        while(false !== ($file = readdir($handle)))  {
            if(check_file_galerij($file)){
                //Het is een plaatje, laat hem zien...
                $file_array[] = $file;

            }
        }
        closedir($handle);
		sort($file_array);
    }
    return $file_array;
}

$file_list = get_file_array($dirname);
$sql = "SELECT * FROM `files`";
$result = $db->select($sql);
$rows = $db->row_count;
if ($rows >= 1) {
	for ($i=1; $i<=$rows; $i++) {
		extract($db->get_row($result));
		$extentie = extention($naam);
		$file_naam_clean = substr($naam, 0, -(strlen($extentie)+1));
		$sql_list[] = $file_naam_clean;
	}
}
//pr($file_list);
//pr($sql_list);

if (count($file_list)>0) {
	foreach ($file_list as $key => $waarde) {
		$status_file = false;
		if (count($sql_list)>0) {
			foreach ($sql_list as $key_sql => $waarde_sql) {
				$regex = '/(^'.$waarde_sql.')/';
				if (preg_match($regex,$waarde)>0) {
					$status_file = true;
				}
			}
		}
		
		// bestand bewaren
		if ($status_file == true) {
			//echo '<br />keep: '.$waarde;
		// bestand verwijderen
		} else {
			//echo '<br />delete: '.$waarde;
			@unlink($dirname.$waarde);
		}
		
	}
}
?>