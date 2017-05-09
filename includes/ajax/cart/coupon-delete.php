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

use Core\Session;
use Core\Controllers\Front\CartController;

//get cart items from session
$session_cart = Session::get('cart');
unset($session_cart->id_cart_rule);
//update cart rule session
if( Session::set('cart', $session_cart) ){
	Session::destroy('cart_content');
	echo json_encode('DONE');
} else {
	echo json_encode('ERROR_DELETE');
}