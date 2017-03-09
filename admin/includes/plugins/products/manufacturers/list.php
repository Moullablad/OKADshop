<?php
$Args = array(
	'Select' => array(
		'id' => 'id' , 
		'name' => 'name', 
		'cdate' => 'cdate', 
		'active' => 'active'
	),
	'From' => array( _DB_PREFIX_.'manufacturers'),
	'Where' => array(),
	'Join' => array(),
	'Module'=> array('manufacturers', l('Gestion des Fabricants', "core") ),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom", "core"),
		l("Date de Création", "core"),
		l("Activé", "core"),
		l("Actions", "core")
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l('Ajouter un fabricant', "core"),'?module=manufacturers&action=add','add_nw','add button', l('Ajouter un fabricant', "core"),'facebox','iconAdd'),
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>