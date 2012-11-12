<?php
## -- includes
include ("includes/thumbnail.inc.php");

## -- paginering
$paginering_aan = false;
$z = 20;
if (!$_GET['page']) {
	$start = 0;
	$page = 1;
	$limiet = $z;
} else {
	$start = (($_GET['page']-1) *$z);
	$page = $_GET['page'];
	$limiet = $z;
}

## -- sql
$sql_files = "SELECT * FROM `files` WHERE `check_id` = '".$array_meta['pagina_id']."' AND `check_type` = 'paginas_galerij' ORDER BY `pos`, `file_id`";
$resultaat_files = mysql_query($sql_files) or die (mysql_error());
$totaal_files = mysql_num_rows($resultaat_files);

$sql_files = $sql_files."DESC LIMIT ".$start.",".$limiet." ";
$resultaat_files = mysql_query($sql_files) or die (mysql_error());
$aantal_files = mysql_num_rows($resultaat_files);

## -- galerij uitvoer
if ($aantal_files > 0) {
	echo'
	<a name="galery" id="galery"></a>
	<div class="galery">
	<div class="clear"></div>
	';
	for ($i=1; $i<=$aantal_files; $i++) {
		$array_files = (mysql_fetch_array($resultaat_files));
		$img_original = $array_files['dir'].$array_files['naam'];
		$img_thumb = $array_files['dir'].set_file_name($array_files['naam']);
		echo '<a class="fbox" rel="galery" href="'.$img_original.'" style="background:url('.$img_thumb.') no-repeat center center;"></a>';
	}	
	echo'
	<div class="clear"></div>
	</div>
	';
	// paginering
	create_nav_get($totaal_files, $page, $limiet, ($_GET['pagina']=='partypics' ? 'partypics/'.$datum.'/' : '').''.$array_meta['meta_url'].'', '.htm#galery');
}
?>