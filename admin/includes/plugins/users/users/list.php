<?php
$Args = array(
	'Select' => array(
		'id'=> _DB_PREFIX_.'users.id',
		'clt_number'=>'clt_number',
		'first_name'=>'first_name',
		'last_name'=>'last_name',
		'email'=>'email',
		'countries'=> _DB_PREFIX_.'countries.name',
		'mobile'=>'mobile',
		'cdate' => _DB_PREFIX_.'users.cdate',
		),
	'From' => array( _DB_PREFIX_.'users'),
	'Where' => array(),
	'Order' => 'FIELD( '._DB_PREFIX_.'users.active, "waiting", "actived") ASC',//= "waiting"users.active DESC
	'Join' => array(
		array( _DB_PREFIX_.'user_company', _DB_PREFIX_.'user_company.id_user', _DB_PREFIX_.'users.id', 'left'),
		array( _DB_PREFIX_.'countries', _DB_PREFIX_.'countries.id', _DB_PREFIX_.'users.id_country','inner'),
	),

	'Module'=> array('users', l("Gestion des clients", "core")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Numéro", "core"),
		l("Prénom", "core"),
		l("Nom", "core"),
		l("E-mail", "core"),
		l("Pays", "core"),
		l("Téléphone", "core"),
		l("Created", "core"),
		l("Operations", "core")
	),
	'Files' => array(),
	'Butons' =>	array(
		array( l("Ajouter un Client", "core"),'?module=users&action=add','add_nw','add button', l("Ajouter un Client", "core"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	