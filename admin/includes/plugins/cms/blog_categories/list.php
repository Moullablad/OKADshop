<?php
$Args = array(
	'Select' => array(
				'id'=> _DB_PREFIX_.'blog_categories.id',
				'title'=> _DB_PREFIX_.'blog_categories.title',
				'description'=> _DB_PREFIX_.'blog_categories.description',
				'lang'=> _DB_PREFIX_.'langs.name'
		  ),
	'From' => array( _DB_PREFIX_.'blog_categories'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'langs', _DB_PREFIX_.'blog_categories.id_lang', _DB_PREFIX_.'langs.id')
		
	),
	'Module'=> array('blog_categories','Gestion des Categories d\'articles'),
	'Operations' => array('edit','delete'),
	'THead' => array('ID','Title','Description','language','Operations'),
	'Butons' =>	array(
		array('Ajouter une catégorie','?module=blog_categories&action=add','add_nw','add button','Ajouter countries','facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?> 