<?php
$Args = array(
	'Select' => array(
		'id' => _DB_PREFIX_.'invoices.id',
		'customer' => 'CONCAT('._DB_PREFIX_.'users.first_name," ",'._DB_PREFIX_.'users.last_name)',
		'reference' => 'reference', 
		'carrier_name' =>  _DB_PREFIX_.'invoice_carrier.carrier_name',
		'carrier_type' => 'carrier_type',
		'company' => 'company', 
		'global_discount' => 'global_discount', 
		'voucher_code' => 'voucher_code', 
		'avoir' => 'avoir', 
		'total_saved' => 'total_saved', 
		'carrier_type' => 'carrier_type'
	),
	'From' => array( _DB_PREFIX_.'invoices'),
	'Where' => array(),
	'Join' => array(
		array( _DB_PREFIX_.'users', _DB_PREFIX_.'invoices.id_customer', _DB_PREFIX_.'users.id', 'left'),
		array( _DB_PREFIX_.'invoice_carrier', _DB_PREFIX_.'invoices.id', _DB_PREFIX_.'invoice_carrier.id_invoice', 'left'),
	),
	'Module'=> array('invoices', l("Gestion des Factures", "core")),
	'Operations' => array('edit','delete'),
	'THead' => array(
		l("ID", "core"),
		l("Nom du Client", "core"),
		l("Réference", "core"),
		l("Transport", "core"),
		l("Formule", "core"),
		l("Socièté", "core"),
		l("Remise globale", "core"),
		l("Bon de réduction", "core"),
		l("Avoir", "core"),
		l("Total économisé", "core"),
		l("Operations", "core")
	),
	'Butons' =>	array(
		//array('Ajouter user','users/add','add_nw','add button','Ajouter countries','facebox','iconAdd')
	),
	'UPLOADFIELDS' => array()
	);
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
	