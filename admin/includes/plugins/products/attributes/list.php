<?php
$Args = array(
	'Select' => array(
		'ID'=>  _DB_PREFIX_.'attributes.id',
		'Name'=>  _DB_PREFIX_.'attributes.name',
		'langs'=>  _DB_PREFIX_.'langs.name'
		),
	'From' => array( _DB_PREFIX_.'attributes'),
	'Where' => array(),
	'Join' => array(
		array(  _DB_PREFIX_.'langs',  _DB_PREFIX_.'langs.id',  _DB_PREFIX_.'attributes.id_lang')
	),//array('countries','countries.id','users.id_country')
	'Module'=> array('attributes', l("Gestion des attributes", "admin")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "admin"),
		l("Nom", "admin"),
		l("Langue", "admin"),
		l("Actions", "admin"),
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l("Ajouter une nouvelle attributes", "admin"),'?module=attributes&action=add','add_nw','add button', l("Ajouter une nouvelle attributes", "admin"),'facebox','iconAdd'),
		//array('Ajouter une nouvelle attributes','attributes/add','add_na','add button','Ajouter countries','facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>