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
		<td style="width:360px; vertical-align:top;">
			Gebruik de knop hiernaast om een youtube code in te geven.<br />
			Plak niet de volledige url naar alleen het deel na de /v/
        </td>
		<td style="vertical-align:top;">
            <form method="post" enctype="multipart/form-data" action="">
				<input name="vcode" value="" size="12" id="vcode" /> <input type="submit" class="button" value="Voeg toe" style="padding: 2px 6px;" id="fileAdd" onclick="upload_tube(); return false;" />
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
		<script language="javascript" type="text/javascript">
        <!--//
		var return_array = new Object();
        
        $(document).ready(function(){
			$('div#thumbnails').disableTextSelect();
			load_gallerij();
        });
		
		function load_gallerij() {
			$.ajax({
				url: 'plugin_youtube/plugin_youtube_show.php',
				data: 'mijn_id=<?php echo $mijn_id; ?>&tabelnaam=<?php echo $module_naam; ?>',
				type: 'GET',
				enctype: 'multipart/form-data',
				success: function(feedback){
					$('#thumbnails').html(feedback);
				},
				error: function(){
					alert('kan films niet vinden...');
				}
			});
		}
		
		function upload_tube() {
			var vcode = $('input#vcode').val();
			if (vcode != '') {
				get_youtube_data(vcode);
				if (return_array['status']==true) {
					// start animatie				
					$('#fileLoader').animate({width:'100%'},1000);
					var yt_data = '&title='+return_array['title']+'&published='+return_array['published']+'&uploader='+return_array['uploader'];
					$.ajax({
						url: 'ajax/add_youtube.php',
						data: 'mijn_id=<?php echo $mijn_id; ?>&tabelnaam=<?php echo $module_naam; ?>&vcode='+vcode+yt_data,
						type: 'POST',
						async: false,
						success: function(feedback){
							$('td#filesStatus').html(feedback.upload_status);
							$('#fileData').show().prepend(feedback.upload_status);
							$('#thumbnails').prepend(feedback.img_preview);
							$('#vcode').val('');
							reset_bars();
						},
						error: function(){
							alert('kan films niet toevoegen...');
						}
					});
				} else {
					return false;
				}
			} else {
				youtube_fout(' code niet ingevuld.');
			}
		}
         
		function get_youtube_data(vcode) {
			$.ajax({
				url: 'http://gdata.youtube.com/feeds/api/videos/'+vcode+'?v=2&alt=json',
				type: 'GET',
				dataType: 'json',
				async: false,
				success: function(feedback){
					if (feedback == null) {
						youtube_fout('Geen antwoord');
					}
					if (feedback['entry']['yt$accessControl']['4']['action'] == 'embed') {
						return_array['embed'] = feedback['entry']['yt$accessControl']['4']['permission'];
						if (return_array['embed'] != 'allowed') {
							youtube_fout(' deze video mag niet extern geembed worden.');
							return false;
						}
					}
					return_array['uploader'] = feedback['entry']['author']['0']['name']['$t'];
					return_array['title'] = feedback.entry.title.$t;
					return_array['published'] = feedback.entry.published.$t;
					return_array['rating'] = feedback.entry.gd$rating.average;	
					return_array['status'] = true;
				},
				error: function(feedback){
					youtube_fout('');
				}
			});
		}
		
		function reset_bars() {
			setTimeout(function() {
				$('#fileLoader').animate({width:'0%'},300);
				$('#fileErrors').hide(300).html('');
				$('#fileData').hide(300).html('');
			}, 2000);
			return_array = Object();
		}
		
		function youtube_fout(yterror) {
			$('td#filesStatus').html('<em>youtube fout</em> '+yterror);
			$('#fileErrors').prepend('<em>youtube fout</em> '+yterror).show();
			return_array['status'] = false;
			reset_bars();
		}
		
		-->
    </script>

    </td>
  </tr>
</table>
