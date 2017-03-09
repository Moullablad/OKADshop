<?php
$Args = array(
	'Select' => array('id' => 'id', 'name' => 'name', 'active' => 'active'),
	'From' => array( _DB_PREFIX_.'taxes_rules_group'),
	'Module'=> array('taxes_rules_group','Liste des règles de taxe'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom de groupe", "core"),
		l("Statut", "core"),
		l("Operations", "core"),
	),
	'Butons' =>	array(
		array( l("Ajouter une règle de taxe", "core"),'?module=taxes_rules_group&action=add','add_nw','add button', l("Ajouter une règle de taxe", "core"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	