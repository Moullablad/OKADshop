<?php
$Args = array(
	'Select' => array(
		'ID'=>'id',
		'Name'=>'name', 
		'active' => 'active'
	),
	'From' => array( _DB_PREFIX_.'users_groups'),
	'Where' => array(),
	'Module'=> array('groups', l("Gestion des groups", "core")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"), 
		l("Nom de Groupe", "core"), 
		l("Activé", "core"), 
		l("Actions", "core")
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l("Ajouter une groupe", "core"),'?module=groups&action=add','add_nw','add button', l("Ajouter une groupe", "core"),'facebox','iconAdd'),
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>