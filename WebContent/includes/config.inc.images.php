<?php
/*

## -- thumbnail afmetingen voor fotogalerij

default thumbnail afmetingen staan gedefinieerd in $thumbs_config['default'];
mocht je in een module willen afwijken doe dit dan in $thumbs_config['pagina']; 
of in $thumbs_config['pagina_type']; als het om een paginatype gaat

*/

// OOK AANPASSEN IN SWF_UPLOAD >> handlers.php

// default
$thumbs_config['default'] = array(130, 73); // breedte, hoogte

// paginas
$thumbs_config['pagina'] = array(
	'nieuws' => array(160, 90),
);

// pagina types
$thumbs_config['pagina_type'] = array(
	'algemeen' =>  $thumbs_config['default'],
	'portfolio_web' =>  $thumbs_config['default'],
	'portfolio_print' =>  $thumbs_config['default'],
);
?>