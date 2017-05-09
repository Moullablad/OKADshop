<?php
$Args = array(
	'Select' => array('id' => 'id', 'name' => 'name', 'active' => 'active'),
	'From' => array( _DB_PREFIX_.'zones'),
	'Module'=> array('zones','Liste des Zones'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom de la zone", "core"),
		l("Statut", "core"),
		l("Operations", "core"),
	),
	'Butons' =>	array(
		array( l("Ajouter une Zone", "core"),'?module=zones&action=add','add_nw','add button', l("Ajouter une Zone", "core"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	