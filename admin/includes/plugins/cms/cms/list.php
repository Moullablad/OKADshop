<?php
$Args = array(
	'Select' => array(
				'id'=> _DB_PREFIX_.'cms.id',
				'title'=> _DB_PREFIX_.'cms.title',
				'category'=> _DB_PREFIX_.'cms_categories.title',
				'lang'=> _DB_PREFIX_.'langs.name'
		  ),
	'From' => array( _DB_PREFIX_.'cms'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'langs', _DB_PREFIX_.'cms.id_lang', _DB_PREFIX_.'langs.id'),
		array( _DB_PREFIX_.'cms_categories', _DB_PREFIX_.'cms.id_cmscat', _DB_PREFIX_.'cms_categories.id')
	),
	'Module'=> array('cms','Gestion de CMS'),
	'Operations' => array('edit','delete','frontview'),
	'THead' => array('ID','Title','Category','language','Operations'),
	'Butons' =>	array(
		array('Ajouter une page','?module=cms&action=add','add_nw','add button','Ajouter une page','facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	