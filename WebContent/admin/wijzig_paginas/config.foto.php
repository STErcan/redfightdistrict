<?php
$array_fotos_types = array(

'algemeen' => 
		array(
			'foto' => array(
				'min_w'=>980, 'min_h'=>322, 
				'cropsize'=>false, 
				'ratio'=>true, 		  
				'descr' => 'Hoofdfoto'
			),
		),
'games' => 
		array(
			'foto' => array(
				'min_w'=>980, 'min_h'=>322, 
				'cropsize'=>false, 
				'ratio'=>true, 		  
				'descr' => 'Hoofdfoto'
			),
		),
);

$array_fotos = $array_fotos_types[$_GET['type']];
?>