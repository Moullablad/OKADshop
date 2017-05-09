<?php
$Args = array(
	'Select' => array(
		'ID'=>  _DB_PREFIX_.'attribute_values.id',
		'Name'=> _DB_PREFIX_.'attribute_values.name',
		'langs'=> _DB_PREFIX_.'langs.name'),
	'From' => array( _DB_PREFIX_.'attribute_values'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'langs', _DB_PREFIX_.'langs.id', _DB_PREFIX_.'attribute_values.id_lang')
	),
	'Module'=> array('values', l('Gestion des Valeurs', "core") ),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom", "core"),
		l("Langue", "core"),
		l("Actions", "core"),
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l('Ajouter une Valeur', "core"),'?module=values&action=add','add_nw','add button', l('Ajouter une Valeur', "core"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>