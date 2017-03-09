<?php
$Args = array(
	'Select' => array(
		'id' => 'id', 
		'name' => 'name', 
		'iso_code' => 'iso_code', 
		'iso_code_num' => 'iso_code_num', 
		'sign' => 'sign', 
		'active' => 'active'
	),
	'From' => array( _DB_PREFIX_.'currencies'),
	'Module'=> array('currencies','Liste des Devises'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom de Devise", "core"),
		l("Code ISO", "core"),
		l("N° de Code ISO", "core"),
		l("Symbole", "core"),
		l("statut", "core"),
		l("Operations", "core")
	),
	'Butons' =>	array(
		array( l("Ajouter un Devise", "core"),'?module=currencies&action=add','add_nw','add button', l("Ajouter un Devise", "core"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	