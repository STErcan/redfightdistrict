<div id="dialog" title="">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="dialog_content"></span></p>
</div>
<script language="javascript" type="text/javascript">
// loader
var load_img = '<img src="css/<?php echo $admin_css; ?>/img/ajax_loader.gif" />';
$('#loading').html(load_img);

// defaults
var array_editors = Array(); /* array tekst-velden die door fck-editor worden vervangen */
<?php echo $array_editors; ?>

// verwijderen
function verwerk_item(id,actie) {
	var melding = '<?php echo $melding_verwijder; ?>';
	var foutmelding = '<?php echo $foutmelding_verwijder; ?>';
	
	$("#dialog").attr('title','Waarschuwing!');
	$("#dialog_content").html(melding);
	
	$(function() {
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:150,
			width:280,
			modal: true,
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Ja, verwijderen': function() {
					$(this).dialog('close');
					// item verwijderen
					loader_show();
					$.ajax({
						url: 'wijzig_<?php echo $module_naam; ?>/ajax_verwerking.php',
						data: actie+'=1&id='+id,
						type: 'GET',
						success: function(feedback){
							$("#item_"+id).addClass('verwijderen').animate({'opacity':'0'},600).slideUp(600);
						},
						error: function(){
							alert(foutmelding);
						},
						complete: function(){
							loader_hide();
						}
					});
				},
				'Nee': function() {
					$(this).dialog('close');
					loader_hide();
				}
			}
		});
	});
		
	return false;
}
	
// submit formulier
function submit_form(form) {
    $('form[name="'+form+'"]').submit();
}
 

// reset weergave
function reset_nieuw() {
	$('#nieuw_item').fadeOut(0);
	$('#nieuw_item').fadeIn(500);
}

// php sessie verwerken
function set_sessie(sessie_naam, sessie_waarde) {
	loader_show();
	$.ajax({
		url: 'ajax/set_sessie.php',
		data: 'sessie_naam='+sessie_naam+'&sessie_waarde='+sessie_waarde+'&datum='+Date(),
		type: 'GET',
		success: function(feedback){
			loader_hide();
		}
	});
}

// markeer labels en geef onclick
function check_labels(div) {
	var input_data = $(div+" :input");
	$.each(input_data, function( intIndex, objValue ){
		
		// is het een checkbox?
		type = input_data[intIndex].type;
		if (type == 'checkbox') {
			if ($('#'+input_data[intIndex].name).is(':checked')) {
				$('#'+input_data[intIndex].name).parent().addClass('actief');
			}
			
		$('#'+input_data[intIndex].name).click(function () { 
			if ($(this).is(':checked')) {
				$(this).parent().addClass('actief');
			} else {
				$(this).parent().removeClass('actief');
			}
		});
			
			
		}
	});
}

// document ready
$(document).ready(function(){
	// meldingen animeren
	var melding = $('#melding');
	if (melding.length) {
		melding.css('opacity','1');
		melding.bind("mouseover", function() {
			$(this).css({'opacity':'0.7', 'cursor':'pointer'});
		});
		melding.bind("mouseout", function() {
			$(this).css('opacity','1');
		});
		melding.bind("click", function() {
			$(this).slideUp();
		});
	}
	
	// login form enter
	var login_form = $('form[name=login_form]');
	if (login_form.length) { 

		$(':input').focus(function() {                
			shortcut.add("enter",function() {
				login_form.submit();
			});
		});

	}
	
	shortcut.add("Ctrl+S",function() {
		document.forms['form'].submit();
	});

	// form button styling
	$(".button").button();

	// disable text selection
	$('.opsomming').disableTextSelect();

	// datum velden
	$('.datum').datepicker({
		changeMonth: true,
		changeYear: true,
		duration: 'fast'
	});
});
</script>