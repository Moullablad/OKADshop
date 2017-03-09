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
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	die();
}

//prepare data
$id_product = intval($_POST['id_product']);
$id_declinaison = intval($_POST['id_declinaison']);

//exit if error
if( $id_product < 1 )
	return false;


//cart instance
use Core\Controllers\Front\CartController;
$cart = new CartController();
$success = $cart->removeFromCart($id_product, $id_declinaison);
if( $success ){
	$return['success'] = 'Item was deleted';
	echo json_encode($return);
}