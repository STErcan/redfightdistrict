	<div class="left">
    	<div class="box_top"></div>
    	<div class="box_center">
			<?php
				$menu = 'nieuws';
				$mijn_id = $array_meta['pagina_id'];
				require_once('plugin.menu_side.php');
			?>
        </div>
    	<div class="box_bottom"></div>
    </div>
	<div class="center">
	<?php
	// get hoofdfoto
	$sql_pic = "SELECT `dir`,`naam` FROM `files` WHERE `check_id` = '".$array_meta['pagina_id']."' AND `check_type` = 'nieuws_foto_nieuwsfoto' LIMIT 1";
	$result_pic = $db->select($sql_pic);
	$rows_pic = $db->row_count;
	if ($rows_pic == 1) {
		extract($db->get_row($result_pic));
		echo '<img src="'.$dir.$naam.'" />';
	}

	
	echo '<h1>'.$array_meta['titel'].'</h1>';
	echo ''.$array_meta['tekst'].'';
	require_once('module.galerij.php');
	require_once('module.bijlagen.php');
	?>

    </div>
    
	<div class="right">
    	<div class="box_top"></div>
    	<div class="box_center">
			<?php
				require_once('plugin.partypics_sidebar_right.php');
			?>
        </div>
    	<div class="box_bottom"></div>
    </div>