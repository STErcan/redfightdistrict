<?php

// show tabs
echo '
<a href="#" onclick="close_tab();reload_pagina(\'overzicht.php\');" id="sublink">&laquo; terug naar het overzicht</a>
<h3>'.$item_titel.' '.($_GET['id']>0 ? 'wijzigen' : 'toevoegen').'</h3>
';


// show tabs
echo '
<div id="tabs">
	<ul>
		<li id="omschrijving">
			<a href="#" onClick="set_tab('.$_GET['id'].',\'omschrijving\'); return false">Omschrijving</a>
		</li>
		'.($_GET['id']>0 ? '
			<li id="items">
				<a href="#" onClick="set_tab('.$_GET['id'].',\'items\'); return false">Extra Inhoud</a>
			</li>
			<li id="versturen">
				<a href="#" onClick="set_tab('.$_GET['id'].',\'versturen\'); return false">Versturen</a>
			</li>
		' : '' ).'
	</ul>
</div>
';


?>
<script language="javascript" type="text/javascript">
<!--//
$(document).ready(function(){
	set_tab(<?php echo $_GET['id'].",'".($_GET['tab'] ? $_GET['tab'] : 'omschrijving')."'"; ?>);
});
// -->
</script>
