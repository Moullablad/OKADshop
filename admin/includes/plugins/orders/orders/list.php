<?php
$Args = array(
	'Select' => array(
		'id' => _DB_PREFIX_.'orders.id',
		'customer' => 'CONCAT('._DB_PREFIX_.'users.first_name," ",'._DB_PREFIX_.'users.last_name)',
		'reference' => 'reference', 
		'carrier_name' => _DB_PREFIX_.'order_carrier.carrier_name',
		'carrier_type' => 'carrier_type',
		'date' => _DB_PREFIX_.'order_carrier.cdate', 
		'global_discount' => 'global_discount', 
		'voucher_code' => 'voucher_code', 
		'avoir' => 'avoir', 
		'total_saved' => 'total_saved', 
		'carrier_type' => 'carrier_type'
	),
	'From' => array( _DB_PREFIX_.'orders'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'users', _DB_PREFIX_.'orders.id_customer', _DB_PREFIX_.'users.id', 'left'),
		array( _DB_PREFIX_.'order_carrier', _DB_PREFIX_.'orders.id', _DB_PREFIX_.'order_carrier.id_order', 'left'),
	),
	'Module'=> array('orders', l("Gestion des Commandes", "core")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom du Client", "core"),
		l("Réference", "core"),
		l("Transport", "core"),
		l("Formule", "core"),
		l("Date", "core"),
		l("Remise globale", "core"),
		l("Bon de réduction", "core"),
		l("Avoir", "core"),
		l("Total économisé", "core"),
		l("Operations", "core"),
	),
	'Butons' =>	array(
		//array('Ajouter user','users/add','add_nw','add button','Ajouter countries','facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	