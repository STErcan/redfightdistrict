<?php
// show tabs
echo '
<a href="?pagina='.$_GET['pagina'].'&amp;content=overzicht" id="sublink">&laquo; terug naar het overzicht</a>
<h3>'.$item_titel.' '.($_GET['id']>0 ? 'wijzigen' : 'toevoegen').'</h3>
';


// inhoud
echo '<div id="tab">'."\n";
require_once('form_omschrijving.php');
echo '</div>'."\n";
?>
