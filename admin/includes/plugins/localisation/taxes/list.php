<?php
$Args = array(
	'Select' => array('id' => 'id', 'name' => 'name', 'rate' => 'rate'),
	'From' => array( _DB_PREFIX_.'taxes'),
	'Module'=> array('taxes', l("Liste des Taxes", "core")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Taxe Label", "core"),
		l("Valeur de taxe (%", "core"),
		l("Operations", "core"),
	),
	'Butons' =>	array(
		array( l("Ajouter une taxe", "core"),'?module=taxes&action=add','add_nw','add button', l("Ajouter une taxe", "core"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	