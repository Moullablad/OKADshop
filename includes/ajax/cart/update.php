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

//cart instance
use Core\Session;
use Core\Controllers\Front\CartController;

//update cart session
$cart = Session::get('cart');
unset($cart->items);

//update cart items
$items = json_decode($_POST['items'], true);
if( !empty($items) ){
	$cart->items = $items;
	Session::set('cart', $cart);	
}
Session::destroy('cart_content');

$cart = new CartController();
$return_cart = $cart->getCartItems();
echo json_encode($return_cart);
