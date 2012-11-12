<?php
require_once('config.php');
// fotoconfig laden
if ($_GET['check_type'] == 'paginas') {
	# wijzig_paginas
	include('../wijzig_paginas/config.foto.php');
	$settings = $array_fotos_types[$_GET['pagina_type']][$_GET['array_key']];
} else {
	include('../wijzig_'.$_GET['check_type'].'/config.foto.php');
	$settings = $array_fotos[$_GET['array_key']];
}

// minimale afmetingen overschrijven
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
?>
<html>
	<head>
		<script src="../../js/jquery-1.4.2.min.js"></script>
		<script src="../../js/jquery.Jcrop.js"></script>
		<script src="../../js/jquery.timer.js"></script>
		<script language="javascript">
			
			var min_w = <?php echo $min_w; ?>;
			var min_h = <?php echo $min_h; ?>;
			var preview_w = min_w;
			var preview_h = min_h;
			var ratio = (preview_w/preview_h);
			var show_w;
			var show_h;
			var upload_timer;
			var timeout_sec = 30000;
			var timeout_sec_msg = timeout_sec/1000;
			var timeout_msg = 'Het uploaden en verwerken van uw afbeelding duurde langer dan '+timeout_sec_msg+' seconden.<br>Wij raden aan een <b>kleiner bestand</b> te uploaden.';
					
			function set_crop_vars(width,height){
				show_w = width;
				show_h = height;
				
				upload_timer.stop();
			}

			function kill_iframe(){
				parent.hidden_cropframe.location.href = 'about:blank';
			}

			// Remember to invoke within jQuery(window).load(...)
			// If you don't, Jcrop may not initialize properly
			function init_cropper(){

				// als deze functie wordt opgeroepen, is de upload gelukt! dus einde controle timer
				var crop_item = $('#cropbox').Jcrop({
					onChange: showPreview,
					onSelect: showPreview,
					setSelect: [ 5, 5, min_w, min_h ],
					bgOpacity: .6,
					minSize: [min_w,min_h],
					<?php echo ($ratio===false ? "\n" : "aspectRatio: ratio,\n"); ?>
					keySupport: false
				});
			}

			// Our simple event handler, called from onChange and onSelect
			// event handlers, as per the Jcrop invocation above
			function showPreview(coords)
			{
				/*
				var rx = preview_w / coords.w;
				var ry = preview_h / coords.h;

				$('#preview').css({
					width: Math.round(rx * show_w) + 'px',
					height: Math.round(ry * show_h) + 'px',
					marginLeft: '-' + Math.round(rx * coords.x) + 'px',
					marginTop: '-' + Math.round(ry * coords.y) + 'px'
				});
				*/
				
				showCoords(coords);
				
			}
			
			// set geen_crop coordinaten in velden
			function setCoords(w,h)
			{
				$('#w').val(w);
				$('#h').val(h);
				$('#x').val(0);
				$('#y').val(0);
			};
			
			// set coordinaten in velden
			function showCoords(c)
			{
				$('#w').val(c.w);
				$('#h').val(c.h);
				$('#x').val(c.x);
				$('#y').val(c.y);
			};
			
			// laat crop foto zien
			function show_crop()
			{
				$('#crop_container').fadeIn('slow');
				setTimeout(function() {
					$('#loader').fadeOut(500);
				}, 500);
			};
			
			// laat normale foto zien
			function show_geen_crop()
			{				
				$('#crop_container').fadeIn('slow');
				setTimeout(function() {
					$('#loader').fadeOut(500);
				}, 500);
			};
			
			// set coordinaten in velden
			function submit_crop()
			{
				var val_w = $('#w').val();
				var val_h = $('#h').val();
				var val_x = $('#x').val();
				var val_y = $('#y').val();
				var val_f = $('#f').val();
				var val_rand = new Date().getTime();
				
				var new_img = document.createElement('img');
				$(new_img).attr({ id: 'ready_img' });
				var new_thumb = document.createElement('img');
				$(new_thumb).attr({ id: 'ready_thumb' });
				
				
				$('#loader').fadeIn(0);
				
				$.ajax({
					type: 'POST',
					url: 'crop_02_submit_crop.php',
					data: 'f='+val_f+'&check_type=<?php echo $_GET['check_type']; ?>&array_key=<?php echo $_GET['array_key'];?>&pagina_type=<?php echo $_GET['pagina_type'];?>&w='+val_w+'&h='+val_h+'&x='+val_x+'&y='+val_y+'&rand='+val_rand,
					cache: false,
					success: function(status){
						$(new_img).attr({ src : '<?php echo $dir.$dir_crop; ?>'+val_f+'?rand='+val_rand});
						$('#ready_container_img').html(new_img);
						$('#ready_container_thumb').html(status);
						setTimeout(function() {
							$('#crop_container').fadeOut(500);
						}, 100);
						setTimeout(function() {
							$('#ready_container').fadeIn(500);
							$('#loader').fadeOut(500);
						}, 600);
					}
				});
			};
			
			// set coordinaten in velden
			function renew_crop()
			{
				var val_f = $('#f').val();
				
				$('#loader').fadeIn(0);
				
				$.ajax({
					type: 'POST',
					url: 'crop_03_remove_crop.php',
					data: 'f='+val_f,
					cache: false,
					success: function(status){
						setTimeout(function() {
							$('#ready_container').fadeOut(500);
						}, 100);
						setTimeout(function() {
							$('#crop_container').fadeIn(500);
							$('#loader').fadeOut(500);
						}, 600);
					}

				});
			}
			
			// submit form
			function submit_form(formnaam)
			{
				document.forms[formnaam].submit();
				$('#crop_container').fadeOut(0);
				$('#ready_container').fadeOut(0);
				$('#error').fadeOut(0);
				
				$('#loader').fadeIn(0);

				upload_timer = $.timer(timeout_sec, function() {
					error(timeout_msg);
					kill_iframe();
					upload_timer.stop();
				});


			}
			
			// submit form
			function error(msg)
			{
				$('#file_up').val('');
				$('#error').html('<b class="fout">Er is een fout opgetreden:</b><br /><br />'+msg);
				$('#error').fadeIn(500);
				$('#loader').fadeOut(0);
				
				upload_timer.stop();
			}
			
			// loader
			$(document).ready(function(){
				if ($.browser.msie) {
					$('#browser_msie').html('<b>Let op:</b> U gebruikt <u>Internet Explorer</u> als webbrowser.<br>Wij raden aan om bij de selectietool voorzichtige bewegingen te maken met uw muis<br>en de cursor niet buiten het plaatje te laten komen.');
						setTimeout(function() {
							$('#browser_msie').fadeIn(500);
						}, 500);
				}
				$('#loader').hide();
			});
			
			function close_fbox() {
				
				var val_f = $('#f').val();
				$.ajax({
					type: 'POST',
					url: 'crop_03_remove_crop.php',
					data: 'f='+val_f+'&actie=accept&check_id=<?php echo $_GET['check_id']; ?>&check_type=<?php echo $_GET['check_type']; ?>&foto=<?php echo $_GET['foto']; ?>&array_key=<?php echo $_GET['array_key'];?>&pagina_type=<?php echo $_GET['pagina_type'];?>',
					cache: false,
					success: function(status){
						var img_url = status;
						$(parent.document).find("#thumb_<?php echo $_GET['foto']; ?>").html('<img src="show_image_preview.php?hoog=100&breed=120&img='+img_url+'" />'); 
						var verwijder_link = $(parent.document).find("#verwijder_<?php echo $_GET['foto']; ?>");
						if(verwijder_link.length==0) {
							$(parent.document).find("#thumb_<?php echo $_GET['foto']; ?>").parent().parent().append('<a href="#" onclick="delete_pic(\'<?php echo $_GET['foto']; ?>\',\'<?php echo $_GET['array_key'];?>\'); return false;" id="verwijder_<?php echo $_GET['foto']; ?>" class="verwijder">verwijderen</a>');
						}
						setTimeout(function() {
							window.parent.close_fbox();
						}, 300);
					}

				});
				
			}

		</script>
		<style type="text/css" media="all">
			@import url("../css/style_plugin.css");
			@import url("../css/jcrop.css");
			form {
				margin:0;
			}
			#hidden_cropframe {
				display:none; /* disable om te debuggen */ 
			}
			#crop_upload {
				text-align:center;
				background-color:#eee;
				padding:3px;
			}
			#crop_container {
				text-align:center;
				background-color:#eee;
				padding:3px;
				margin-top:2em;
				display:none;
			}
				#crop_container a#bewaren {
					padding:10px;
					margin:10px;
					width:220px;
					*width:240px;
					display:inline-block;
					background-color:#D2FFD2;
					text-decoration:none;
					color:#000;
					border:1px solid #fff;
				}
			#preview_container {
				overflow:hidden;
				border:1px solid #333;
				display:none;
			}
			#cropbox_container {
				border:1px solid #333;
				display:inline-block;
				margin:3px auto;
				padding:0;
				width:10px;
			}
			#cropbox_container img,
			#cropbox_container thumb {
				margin:0;
			}
			
			#ready_container {
				background-color:#eee;
				padding:3px;
				margin-top:2em;
				display:none;
				text-align:center;
			}
			#ready_container img {
				border:1px solid #333;
			}
			#ready_container_status {
				display:block;
				width:500px;
				margin:1em auto;
			}
			#ready_container_status a#opnieuw, #ready_container_status a#opslaan {
				padding:10px;
				width:220px;
				*width:240px;
				display:inline-block;
				text-decoration:none;
				color:#000;
				border:1px solid #fff;
			}
			#ready_container_status a#opnieuw:hover, #ready_container_status a#opslaan:hover {
				border:1px solid #999;
			}
			#ready_container_status a#opslaan {
				float:right;
				background-color:#D2FFD2;
			}
			#ready_container_status a#opnieuw {
				float:left;
				background-color:#FFBBBB;
			}
			#ready_container_status img {
				border:0;
				margin:0;
			}
			#ready_container_status .clear {
				clear:both;
			}

			body {
				font:.9em 'Verdana';
			}
			#status {
				width:24px;
				display:inline-block;
			}
			#loader {
				line-height:2em;
			}
			#error {
				background-color:#eee;
				padding:3px;
				margin-top:2em;
				display:none;
				text-align:center;
			}
			#error b.fout {
				color:red;
			}
			#browser_msie {
				background-color:#ffa;
				padding:3px;
				margin-top:2em;
				display:none;
				text-align:center;
			}
			
			.thumbnail_preview {
				display:inline-block;
				padding:6px;
				margin:3px;
				background-color:#fff;
				border:1px dotted #aaa
			}
			.thumbnail_preview span {
				display:block;
				padding:3px;
				margin:6px 6px 0 6px;
			}
        </style>
	</head>

	<body>
		<div id="crop_upload">
        <form action="crop_01_upload.php" method="post" target="hidden_cropframe" enctype="multipart/form-data" name="upload_form">
        <input id="check_type" name="check_type" value="<?php echo $_GET['check_type']; ?>" type="hidden" />
        <input id="array_key" name="array_key" value="<?php echo $_GET['array_key']; ?>" type="hidden" />
        <input id="pagina_type" name="pagina_type" value="<?php echo $_GET['pagina_type']; ?>" type="hidden" />
        <input id="geen_crop" name="geen_crop" value="<?php echo $geen_crop; ?>" type="hidden" />
        Afbeelding uploaden: &nbsp; <input id="file_up" name="file_up" type="file" onChange="submit_form('upload_form');" /> &nbsp; <span id="status"><img id="loader" src="../img/loading_zw.gif" /></span>
        </form>
        <iframe width="500" height="200" name="hidden_cropframe" src="crop_01_upload.php" id="hidden_cropframe"></iframe>
        </div>
<?php
echo '
		<div id="crop_container">
        Foto bijsnijden:<br>
        <div id="cropbox_container"></div>
		<!--Voorbeeld thumbnail-->
        <div id="preview_container"></div>
        <form>
            <input id="w" value="" type="hidden" />
            <input id="h" value="" type="hidden" />
            <input id="x" value="" type="hidden" />
            <input id="y" value="" type="hidden" />
            <input id="f" value="" type="hidden" />
            <input id="thumb" value="" type="hidden" />
            <a href="#" onClick="submit_crop(); return false;" id="bewaren">Ga verder &raquo;</a>
        </form>
        </div>
        
        
        <div id="ready_container">
        	<strong>Voorbeeld:</strong>
            <div id="ready_container_img"></div>
            <br />
			'.($thumbnail ? '
        	<div id="ready_container_thumb"></div>
			' : '').'

            <div id="ready_container_status">
				'.(!$geen_crop ? '
            	<a href="#" onClick="close_fbox(); return false;" id="opslaan">
                	<img src="../img/icons/verder_32.png" align="right" /> Klik hier om de nieuwe afbeelding op te slaan.
                </a>
                <a href="#" onClick="renew_crop(); return false;" id="opnieuw">
                    <img src="../img/icons/reload_red_32.png" align="left" /> Klik hier om de afbeelding <br>opnieuw bij te snijden.
                </a>
				
				' : '
            	<a href="#" onClick="close_fbox(); return false;" id="opslaan" style="float:none;">
                	<img src="../img/icons/verder_32.png" align="right" /> Klik hier om de nieuwe afbeelding op te slaan.
                </a>
				').'
            	<div class="clear"></div>
            </div>
            <br />
            
        </div>
        
        
        <div id="error"></div>
        <div id="browser_msie"></div>
	</body>

</html>
';  
