<?php
// show tabs
echo '
<a href="?pagina='.$_GET['pagina'].'&amp;type='.$_GET['type'].'&amp;content=overzicht" id="sublink">&laquo; terug naar het overzicht</a>
<h3>'.$item_titel.' '.($_GET['id']>0 ? 'wijzigen' : 'toevoegen').'</h3>
';


echo '
<div id="tab" style="padding:1px;"></div>
';
require_once('form_omschrijving.php');
?>