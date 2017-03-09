<?php
/**
 * 2016 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 OKADshop
 */

include '../../../config/bootstrap.php';

//This is an ajax request
if( !is_ajax() ){
	die();
}

use Core\Controllers\Front\AddressController;
use Core\Session;

$id_address = intval($_POST['id_address']);
$address_type = $_POST['type'];

if( $id_address > 0 ) {
	//save choice in session
	if( $address_type == 'delivery' ){
		create_session('addr_delivery', $id_address);
	} else {
		erase_session('use_same_address');
		create_session('addr_billing', $id_address);
	}
	$address = AddressController::getAddressByID($id_address);
	if( $address ){
		$return['address'] = $address;
	} 
} else {
	erase_session('addr_'.$address_type);
	$return['address'] = "DONE";
}
echo json_encode($return);