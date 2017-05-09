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
 *
 * ------------------------------------------------------------------
 * THIS FILE GROUP ALL HOOK FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */


use Core\Session;




/**
 *=============================================================
 * ORDER DATA RESET
 *=============================================================
 * @return boolean
 */
function order_data_reset(){
	erase_session('id_carrier');
	erase_session('order_step');
	erase_session('cart');
	erase_session('cart_content');
	erase_session('addr_delivery');
	erase_session('addr_billing');
	erase_session('payment_method');
}
add_action('os_after_order_details', 'order_data_reset');




/**
 * Set module admin pages
 */
function set_stock_admin_pages() {
	if( ! is_admin() ) return;
	$module = get_url_param('module');
	if( $namespace = get_module_namespace($module) ) {
		$className = $namespace .'Controllers\\Pages';
		if( class_exists($className) ) {
			$controller = new $className(); // Get class Instance
			return $controller->setAdminPage();
		}
	}
} 
add_action('init', 'set_stock_admin_pages');