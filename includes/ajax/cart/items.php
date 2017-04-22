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

use Core\Controllers\Front\CartController;

//prepare data
$return = array();
$qty_match = true;
$id_product = intval($_POST['id_product']);
$id_declinaison = intval($_POST['id_declinaison']);
$qty = intval($_POST['qty']);

//exit if error
if( $id_product < 1 || $qty < 1 )
	return false;

// $db = getDB();
//check if quantity match min product qty
if( $id_declinaison > 0 ){
	$comb = findByColumn('declinaisons', 'id', $id_declinaison, ['min_quantity'], true);
	if( $qty < $comb->min_quantity ){
		$min_quantity = $comb->min_quantity;
		$qty_match = false;
	}
} else {
	$product = findByColumn('products', 'id', $id_product, ['min_quantity'], true);
	if( $qty < $product->min_quantity ){
		$min_quantity = $product->min_quantity;
		$qty_match = false;
	}
}
if( !$qty_match ){
	$return['error'] = trans("Min quantity is:", "core") .' '. $min_quantity;
} else {
	$cart = new CartController();
	//define args
	$args = new \stdClass;
	$args->id_product = $id_product;
	$args->id_declinaison = $id_declinaison;
	$args->qty = $qty;


	//update cart items
	if( $cart->addToCart($args) ){
		$return['cart'] = $cart->getCartItems();
	}
}
echo json_encode($return);

