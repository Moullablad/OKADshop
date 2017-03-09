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
 * ACCOUNT TABS
 * ------------------------------------------------------------------
 *
 */


/**
 * Register Orders Tabs
 */
$orders_tabs = array(
	'infos' => array(
		'name' => trans("Order Informations", "orders"),
		'function' => 'order_infos_tab',
	)
);
add_tabs(__FILE__, 'orders', $orders_tabs);


/**
 * Orders infos tab
 */
function order_infos_tab(){
	$data = array();
	$db = getDB();
	$id_user = get_user('id');

	get_view(__FILE__, 'admin/tabs/infos', $data);
}
