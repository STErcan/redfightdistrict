<style type="text/css">
	.error {
		border:1px dotted red;
		padding:.5em;
		margin:.5em 0;
		display:none;
	}
		.error em {
			color:red;
			font-style:normal;
		}
	.status {
		border:1px dotted green;
		padding:.5em;
		margin:.5em 0;
		display:none;
		height:2em;
		overflow:auto;
	}
		.status em {
			color:green;
			font-style:normal;
		}

	#filesStatus em {
		color:red;
		font-style:normal;
	}

</style>
<table border="0" cellspacing="0" cellpadding="4" class="form algemeen">
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td style="width:340px; vertical-align:top;">
            Hieronder staat de fotogalerij voor deze pagina.<br />
            Klik op de knop rechts om nieuwe foto's te selecteren
        </td>
		<td style="vertical-align:top;">
            <form>
                <div id="Buttoncontainer"> <span id="spanButtonPlaceHolder">hier zou een knop moeten staan...</span> </div>
            </form>
		</td>
	</tr>
	<tr>
		<td colspan="2">
            <table cellspacing="0" cellpadding="0" style="display:block;" id="swf_status">
                <tr>
                    <td align="right"><strong>Huidige actie:&nbsp;</strong></td>
                    <td id="filesStatus"></td>
                </tr>			
            </table>
        </td>
	</tr>
	<tr class="sub_lijn">
      <td colspan="2">
        <div id="prullenbak_container">
            <div id="prullenbak"></div>
        	<div id="legenda">
                <img src="img/icons/back_16.png" alt="verplaatsen" class="bar" align="absmiddle" /> Sorteren<br />
                <img src="img/icons/delete_16.png" alt="verwijderen" align="absmiddle" />  Verwijderen
            </div>
        </div>
        
        <div id="preview_container">
            <div id="fileLoader" style="background-color:#f60; width:0%; height:4px;"></div>
            <div id="fileErrors" class="error"></div>
            <div id="fileData" class="status"></div>
            
        	<div id="thumbnails"></div>
        	<div class="clear"></div>
        </div>

        <div id="info"></div>
		<script type="text/javascript" src="<?php echo $upload_dir['base']; ?>admin/js/swfupload/swfupload.js"></script>
        <script type="text/javascript" src="<?php echo $upload_dir['base']; ?>admin/js/swfupload/swfupload.queue.js"></script>
        <script type="text/javascript" src="<?php echo $upload_dir['base']; ?>admin/js/swfupload/swfupload.speed.js"></script>
        <script type="text/javascript" src="<?php echo $upload_dir['base']; ?>admin/js/swfupload/handlers_gallery.js"></script>
		<script language="javascript" type="text/javascript">
        <!--//
        var swfu;
        
        $(document).ready(function(){
			$('div#thumbnails not:textarea').disableTextSelect();
			
			var file_size = '4 MB';
            var settings = {
                flash_url: "<?php echo $upload_dir['base']; ?>admin/js/swfupload_fp10/swfupload.swf",
                flash9_url: "<?php echo $upload_dir['base']; ?>admin/js/swfupload_fp9/swfupload_fp9.swf",
				upload_url: "<?php echo $upload_dir['base']; ?>admin/ajax/upload_gallery.php",	// Relative to the SWF file or absolute
                post_params: {'tabelnaam':'<?php echo $module_naam; ?>', 'mijn_id':'<?php echo $mijn_id; ?>', 'dir':'<?php echo $upload_dir['base_galerij']; ?>'},
        
                // File Upload Settings
                file_size_limit: file_size,
                file_types: "*.jpg; *.gif; *.png",
                file_types_description: "Afbeeldingen",
                file_upload_limit: 0,
                file_queue_limit: 20,
        
                debug: false,
        
				// Button settings
				button_placeholder_id: "spanButtonPlaceHolder",
				button_width: 190,
				button_height: 28,
				button_text_top_padding: 6,
				button_text_left_padding: 22,
				button_text: '<span class="button">Selecteer foto\'s <span class="buttonSmall">(Max. '+file_size+')</span></span>',
				button_text_style: '.button { font-family:Verdana; font-size:10px; font-weight:bold;} .buttonSmall { font-size: 9px; font-weight:normal; }',
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,
                
                moving_average_history_size: 1,
                
                // The event handler functions are defined in handlers.js
				swfupload_preload_handler: preLoad,
				swfupload_load_failed_handler: loadFailed,
				file_queue_error_handler: fileQueueError,
				file_queued_handler: fileQueued,
				file_dialog_complete_handler: fileDialogComplete,
				upload_start_handler: uploadStart,
				upload_progress_handler: uploadProgress,
				upload_success_handler: uploadSuccess,
				upload_complete_handler: uploadComplete,
                
                // speedometer
                custom_settings : {
                    fileData: $("#fileData"),
                    fileErrors: $("#fileErrors"),
                    filesStatus: $("#filesStatus"),
                    filesQueued: $("#filesQueued"),
                    filesUploaded: $("#filesUploaded"),
                    fileLoader: $("#fileLoader")
                }
            };
        
			swfu = new SWFUpload(settings);
			load_gallerij();
			
        });
         
		function load_gallerij() {
			$.ajax({
				url: 'plugin_galerij/plugin_galerij_show.php',
				data: 'mijn_id=<?php echo $mijn_id; ?>&tabelnaam=<?php echo $module_naam; ?>',
				type: 'GET',
				enctype: 'multipart/form-data',
				success: function(feedback){
					$('#thumbnails').html(feedback);
				},
				error: function(){
					alert('kan fotos niet vinden...');
				}
			});
		}
		-->
    </script>

    </td>
  </tr>
</table>
