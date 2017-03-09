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
 * Register Account Tabs
 */
attach_tabs('account', 'account', array(
	'orders' => array(
		'name' => trans("Orders", "orders"),
		'function' => 'account_orders_tab',
		'position' => 3
	)
));

/**
 * My order tab
 */
function account_orders_tab(){
	$data['orders'] = get_orders();
	get_view(__FILE__, 'front/tabs/orders', $data);
}