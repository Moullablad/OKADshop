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

$code = $_POST['code'];
if( $code == '' ) return fasle;





use Core\Session;
use Core\Cookie;
use Core\Controllers\Front\CartController;


// $cart_session = Session::get('cart');
// $cart = Cookie::destroy('cart');
// $cart = Cookie::set('cart', $cart_session);
// $cart = Cookie::get('cart');
// var_dump($cart);
// exit;

$cart = new CartController();
$id_cart_rule = $cart->checkVoucherCode( $code );

if( $id_cart_rule ){

	//get cart items from session
	$session_cart = (array) Session::get('cart');

	$session_cart['id_cart_rule'] = $id_cart_rule;

	//add cart rule to session
	if( Session::set('cart', (object) $session_cart) ){
		Session::destroy('cart_content');
		echo json_encode('DONE');
	} else {
		echo json_encode('ERROR_SAVE');
	}

} else {
	echo json_encode('NOT_FOUND');
}