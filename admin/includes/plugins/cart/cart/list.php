<?php
$Args = array(
	'Select' => array(
		'id' => 'id', 
		'name' => 'name', 
		'code' => 'code', 
		'date_to' => 'date_to', 
		'minimum_amount' => 'minimum_amount', 
		'quantity' => 'quantity', 
		'reduction' => 'reduction', 
		'active' => 'active'
	),
	'From' => array( _DB_PREFIX_.'cart_rule'),
	'Module'=> array('cart','Règles panier'),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom de la Règle", "core"),
		l("Code promo", "core"),
		l("Date d\'expiration", "core"),
		l("Montant minimum", "core"),
		l("Quantité disponible", "core"),
		l("Réduction", "core"),
		l("Statut", "core"),
		l("Operations", "core"),
	),
	'Butons' =>	array(
		array( l("Ajouter une Règle", "core"),'?module=cart&action=add','add_nw','add button', l("Ajouter une Règle", "core"),'facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	