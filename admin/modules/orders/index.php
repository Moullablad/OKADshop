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

if (!defined('_OS_VERSION_'))
  exit;


include 'includes/class/order.php';
include 'includes/tabs/account.php';
include 'includes/tabs/orders.php';



/**
 * Register CSS and JS
 */
add_css('orders-style', [
	'src' => admin_url('modules/orders/assets/css/orders.css'), 
	'admin' => true
]);
add_js('orders-scripts', [
	'src' => admin_url('modules/orders/assets/js/orders.js'), 
	'admin' => true
]);



/**
 * Register front pages
 */
function order_front_page(){
	$page = $_GET['ID'];
	if( !isset($page) || $page == '' ){
		header("Location: ". get_url());
	}
	$order = new Order();
	$class_function = str_replace('-', '_', $page);
	if(method_exists($order, $class_function)) {
		$order->$class_function();
	} else {
		header("Location: ". get_url('order/summary'));
	}
}
add_front_page(__FILE__, 'order', 'order_front_page');