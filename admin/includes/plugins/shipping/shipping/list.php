<?php
$Args = array(
	'Select' => array(
		'ID' =>  _DB_PREFIX_.'carrier.id', 
		'name' =>  _DB_PREFIX_.'carrier.name', 
		'min_delay' => 'min_delay', 
		'max_delay' => 'max_delay',  
		'grade' => 'grade', 
		'max_width' => 'max_width', 
		'max_height' => 'max_height', 
		'max_depth' => 'max_depth',  
		'max_weight' => 'max_weight'
	),
	'From' => array( _DB_PREFIX_.'carrier'),

	'Join' => array(),
	'Module'=> array('shipping', l("Liste des Transports", "core")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom de Transport", "core"),
		l("Délai Min", "core"),
		l("Délai Max", "core"),
		l("Vitesse (km)", "core"),
		l("Largeur Max", "core"),
		l("Hauteur Max", "core"),
		l("Profondeur Max", "core"),
		l("Poids Max", "core"),
		l("Operations", "core")
	),
	'Butons' =>	array(
		array( l("Ajouter un Transport", "core"),'?module=shipping&action=add','add_nw','add button', l("Ajouter un Transport", "core"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	