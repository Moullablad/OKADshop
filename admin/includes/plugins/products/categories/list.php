<?php

$Args = array(
	'Select' => array(
		'ID'=>  _DB_PREFIX_.'categories.id' ,
		'Name'=>  _DB_PREFIX_.'categories.name',
		'langs'=>  _DB_PREFIX_.'langs.name'
	),/*,'Description'=>'','Displayed'=>''*/
	'From' => array( _DB_PREFIX_.'categories'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'langs', _DB_PREFIX_.'langs.id',  _DB_PREFIX_.'categories.id_lang')
	),//array('countries','countries.id','users.id_country')
	'Module'=> array('categories', l('Gestion des categories', "core") ),
	'Operations' => array('edit', 'delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom", "core"),
		l("Langue", "core"),
		l("Actions", "core")
	),
	'Files' => array(),
	'Butons' =>	array(
					array( l('Ajouter une categorie', "core"),'?module=categories&action=add','add_nw','add button',l('Ajouter une categorie', "core"),'facebox','iconAdd')
				),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();


$DATATABLE = $Tables->GET($Args);

?>