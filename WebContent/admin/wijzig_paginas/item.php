<?php
$_GET['tab'] = ($_GET['tab'] ? $_GET['tab'] : $eerste_tab);
// menu
echo '
<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=overzicht" id="sublink">&laquo; terug naar het overzicht</a>
<h3>'.$item_titel.' '.($_GET['id']>0 ? 'wijzigen' : 'toevoegen').'</h3>
';


// melding nieuw item
if (isset($_GET['nieuw']) && ($add_foto == true || $add_galerij == true || $add_bijlagen == true)) {
	echo '
	<div id="melding"><b>Let op:</b> U heeft zojuist een '.$item_pre_nieuw.' '.$item_titel.' aangemaakt. 
	Gebruik de nieuwe tabs om '.$item_pre.' '.$item_titel.' van extra informatie te voorzien.</div>
	';
}

if ($_GET['id']==3) {
	$add_youtube = true;
}

// tabs
echo '
<div id="tabs">
	<ul>
		<li id="'.($form_omschrijving).'"'.($_GET['tab'] == $form_omschrijving ? ' class="active"' : '').'>
			<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab='.($form_omschrijving).'">Omschrijving</a>
		</li>
		'.($_GET['id']>0 ? '
			'.($add_foto ? '
			<li id="fotos"'.($_GET['tab'] == 'fotos' ? ' class="active"' : '').'>
				<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=fotos">Pagina Foto\'s</a>
			</li>
			' : '' ).'
	
			'.($add_galerij ? '
			<li id="galerij"'.($_GET['tab'] == 'galerij' ? ' class="active"' : '').'>
				<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=galerij">Galerij</a>
			</li>
			' : '' ).'
			
			'.($add_bijlagen ? '
			<li id="bijlagen"'.($_GET['tab'] == 'bijlagen' ? ' class="active"' : '').'>
				<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=bijlagen">Bijlagen</a>
			</li>
			' : '' ).'

			'.($add_youtube ? '
			<li id="youtube"'.($_GET['tab'] == 'youtube' ? ' class="active"' : '').'>
				<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=item&amp;id='.$_GET['id'].'&amp;tab=youtube">Youtube video\'s</a>
			</li>
			' : '' ).'

		' : '' ).'
	</ul>
</div>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_'.$_GET['tab'].'.php');
echo '</div>'."\n";
?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	// ## -- permalink
	// wijzig
	$("span.permalink, a#wijzig_permalink").bind('click',function(){
		$("span.permalink").hide();
		var t = setTimeout(function(){
			$("input.permalink").show().focus();
			$("a#wijzig_permalink").hide();
			$("a#save_permalink").show();
			$("a#cancel_permalink").show();
		},100);
	});
	
	// save
	$("a#save_permalink").bind('click',function(){
		
		check_permalink();
		
		$("input.permalink").hide();
		var t = setTimeout(function(){
			$("span.permalink").show();
			$("a#wijzig_permalink").show();
			$("a#save_permalink").hide();
			$("a#cancel_permalink").hide();
		},100);
	});
	
	// cancel
	$("a#cancel_permalink").bind('click',function(){
		$("input.permalink").hide();
		var t = setTimeout(function(){
			$("span.permalink").show();
			$("a#wijzig_permalink").show();
			$("a#save_permalink").hide();
			$("a#cancel_permalink").hide();
		},100);
	});
	
});

function check_permalink() {
	loader_show();
	var permalink = $("input.permalink").val();
	$.ajax({
		url: 'ajax/permalink.php',
		data: 'permalink='+permalink+'&id=<?php echo $_GET['id']; ?>',
		cache: false,
		type: 'GET',
		success: function(feedback){
			var array_feedback = feedback.split('*');
			$("span.permalink").html(array_feedback[0]);
			$("input.permalink").val(array_feedback[1]);
		},
		complete: function(){
			loader_hide();
		}
	});
}
</script>