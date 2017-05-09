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
$account_tabs = array(
	'dashboard' => array(
		'name' => trans("Dashboard", "account"),
		'function' => 'account_dashboard_tab',
		'position' => 1
	),
	'addresses' => array(
		'name' => trans("Addresses", "account"),
		'function' => 'account_addresses_tab',
		'position' => 2
	),
	'credit-slips' => array(
		'name' => trans("Credit slips", "account"),
		'function' => 'account_credit_slips_tab',
		'position' => 3
	)
);
add_tabs(__FILE__, 'account', $account_tabs);


/**
 * Dashboard tab
 */
function account_dashboard_tab(){
	$data = array();
	$db = getDB();
	$id_user = get_user('id');
	$data['user'] = $db->prepare("SELECT u.*, c.name as country, a.addresse as address FROM {$db->prefix}users u LEFT JOIN {$db->prefix}countries c ON c.id = u.id_country LEFT JOIN {$db->prefix}addresses a ON a.id_user = u.id WHERE u.id=?", [$id_user], true);

	get_view(__FILE__, 'front/tabs/dashboard', $data);
}

/**
 * Addresses tab
 */
function account_addresses_tab(){
	//delete address
	if ( isset($_POST['delete_address']) && $_POST['id_address'] > 0 ){
		$delete = delete_address($_POST['id_address']);
		if( $delete ){
			$data['message']['success'] = trans("Address was deleted successfully.", "account");
		} else {
			$data['message']['danger'] = trans("Unable to remove the address.", "account");
		}
	}
	$id_user = get_user('id');
	$data['addresses'] = get_addresses($id_user);
	get_view(__FILE__, 'front/tabs/addresses', $data);
}

/**
 * My order tab
 */
function account_credit_slips_tab(){
	$data = array();
	get_view(__FILE__, 'front/tabs/credit-slips', $data);
}